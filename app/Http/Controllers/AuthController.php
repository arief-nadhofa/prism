<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // function proses_login()
    // {
    //     return redirect()->to('dashboard');
    // }

    function proses_login(Request $request)
    {
        $request->validate([
            'username'      => 'required|string',
            'password'   => 'required|string',
            'login_type' => 'nullable|string|in:user,admin',
        ]);

        $username = $request->input('username');
        $password  = $request->input('password');

        // ==========================================================
        // 2. JALUR KHUSUS USER (100% LDAP ACTIVE DIRECTORY)
        // ==========================================================
        $user = $username;

        if (str_contains($user, '@')) {
            $user = explode('@', $user)[0];
        } elseif (str_contains($user, '\\')) {
            $user = explode('\\', $user)[1];
        }

        $ldapDomain = "@advics-min.co.id";
        $userEmail  = $user . $ldapDomain;
        $bindRdn    = $user . $ldapDomain;

        putenv('LDAPTLS_REQCERT=never');

        if (defined('LDAP_OPT_X_TLS_REQUIRE_CERT')) {
            @ldap_set_option(null, LDAP_OPT_X_TLS_REQUIRE_CERT, 0);
        }

        $ldapHost = 'ldaps://ADS-SVR-SC.advics-min.co.id';
        $ldapConn = @ldap_connect($ldapHost, 636);

        $isLdapSuccess = false;
        $isUserFoundInAd = false;

        if ($ldapConn) {

            ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldapConn, LDAP_OPT_NETWORK_TIMEOUT, 5);

            // Cek user di AD
            $adminBind = @ldap_bind(
                $ldapConn,
                'ADVICS-MIN\\administrator',
                'Advics@2026'
            );

            if ($adminBind) {

                $baseDn = 'DC=advics-min,DC=co,DC=id';

                $filter = "(&(sAMAccountName=$user)(userPrincipalName=$bindRdn))";

                $search = @ldap_search(
                    $ldapConn,
                    $baseDn,
                    $filter,
                    ['samaccountname']
                );

                if ($search) {

                    $entries = @ldap_get_entries($ldapConn, $search);

                    if ($entries && $entries['count'] > 0) {
                        $isUserFoundInAd = true;
                    }
                }
            }

            // Validasi password user LDAP
            $userBind = @ldap_bind($ldapConn, $bindRdn, $password);

            if ($userBind) {
                $isLdapSuccess = true;
                $isUserFoundInAd = true;
            }

            @ldap_close($ldapConn);
        }
        $account = Account::query()
            ->join(
                'user',
                'account.user_id',
                '=',
                'user.id'
            )
            ->where('account.username', $user)
            ->select(
                'account.user_id',
                'account.username',
                'user.fullname',
                'user.npk',
            )
            ->first();



        // Jika berhasil login LDAP: kunci role wajib 'user'
        if ($isLdapSuccess) {


            $request->session()->regenerate();

            $request->session()->put([
                'username' => $user,
                'name' => $account->fullname,
                'npk' => $account->npk
            ]);

            return redirect()->route('dashboard');
        }

        $errorMessage = ($account || $isUserFoundInAd)
            ? 'Username/password salah.'
            : 'Akun Tidak Terdaftar';

        return back()->with([
            'error' => $errorMessage
        ]);
    }


    function proses_logout(Request $request)
    {
        $request->session()->forget([
            'username',
            'name',
            'npk',
        ]);
        return redirect()->route('/')
            ->with('success', 'Berhasil keluar.');
    }
}
