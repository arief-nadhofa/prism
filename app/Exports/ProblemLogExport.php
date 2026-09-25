<?php

namespace App\Exports;

use App\Models\LogProblem;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Problem;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProblemLogExport implements FromQuery, WithHeadings, WithMapping
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query(): Builder
    {
        $query = LogProblem::query()->with([
            'lineDetail',
            'categoryDetail'
        ]);

        if (!empty($this->filters['search'])) {

            $search = $this->filters['search'];

            $query->where(function ($q) use ($search) {

                $q->where('problem', 'like', "%{$search}%")

                    ->orWhereHas('lineDetail', function ($q) use ($search) {
                        $q->where('line', 'like', "%{$search}%");
                    })

                    ->orWhereHas('categoryDetail', function ($q) use ($search) {
                        $q->where('category', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($this->filters['start_date'])) {

            $query->whereDate(
                'start_problem',
                '>=',
                $this->filters['start_date']
            );
        }

        if (!empty($this->filters['end_date'])) {

            $query->whereDate(
                'start_problem',
                '<=',
                $this->filters['end_date']
            );
        }

        return $query->orderByDesc('start_problem');
    }

    public function headings(): array
    {
        return [
            'No',
            'Line',
            'Category',
            'Problem',
            'Status',
            'Created',
            'Solved',
            'Duration'
        ];
    }

    private int $number = 0;

    public function map($problem): array
    {
        return [
            ++$this->number,
            $problem->lineDetail?->line ?? '-',
            $problem->categoryDetail?->category ?? '-',
            $problem->problem,
            $problem->status == 1 ? 'Close' : 'Open',
            $problem->start_problem
                ? Carbon::parse($problem->start_problem)->format('Y-m-d H:i:s')
                : '',
            $problem->finish_problem
                ? Carbon::parse($problem->finish_problem)->format('Y-m-d H:i:s')
                : '',
            $problem->duration ?? '-'
        ];
    }
}
