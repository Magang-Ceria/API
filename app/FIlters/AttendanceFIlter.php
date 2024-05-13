<?

namespace App\Filters;

use Illuminate\Http\Request;

class AttendanceQuery
{
    protected $allowedParams = [
        'name',
        'institution',
        'startperiode',
        'endperiode',
        'date',
        'day',
        'month',
        'year'
    ];

    public function transformQuery (Request $request) 
    {
        
    }
}
