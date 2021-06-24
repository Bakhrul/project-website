<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_item extends Model
{
    protected $table = 'm_item';
    protected $primaryKey = 'i_id';

    public function priceOne()
    {
        return $this->hasMany(m_item_price::class, 'ip_item', 'i_id');
    }

    public function priceTwo()
    {
        return $this->hasMany(m_item_price::class, 'ip_item', 'i_id');
    }
}
