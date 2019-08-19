<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'value', 'addition', 'subtraction', 'multiplication', 'division', 'status',
    ];

    public function getTicketAtSubAttribute()
    {
        return ($this->value + $this->add);
    }

    public function getTicketAtMulAttribute()
    {
        return $this->getTicketAtSubAttribute() - $this->sub;
    }

    public function getTicketAtDivAttribute()
    {
        return $this->getTicketAtMulAttribute() * $this->mul;
    }

    public function getResultAttribute()
    {
        if ($this->div != 0)
            return $this->getTicketAtDivAttribute() / $this->div;
        else
            return 'infiniy';
    }
}
