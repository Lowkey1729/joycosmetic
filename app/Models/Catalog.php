<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{

    protected $fillable = array('name', 'description', 'parent_id', 'image', 'priority', 'updated_at');

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'catalog_id', 'id');
    }

    public function get_catalog_ids_tree(int $id)
    {
        $child_ids = [$id];
        $catalog_ids = [];
        do {
            $catalog_ids = array_merge($catalog_ids, $child_ids);
            $child_ids = $this::whereIn('parent_id', $child_ids)->pluck('id')->toArray();
        }
        while ($child_ids);
        return $catalog_ids;
    }

    public function parentsNode()
    {
        return $this->where('parent_id', NULL)->get();
    }
}
