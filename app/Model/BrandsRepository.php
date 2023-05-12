<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

final class BrandsRepository
{
    public function __construct(
		private Nette\Database\Explorer $database,
	) {
	}

    public function listBrands(int $asc = 1) : Selection
    {
        $order = $asc ? 'name' : 'name DESC';
        return $this->database
            ->table('brands')
            ->order($order);
    }

    public function getById(int $id) : ActiveRow
    {
        return $this->database->table('brands')->get($id);
    }

    public function insertOrUpdate(iterable $data) : bool|int|ActiveRow
    {
        //some validation or other magic in real life app

        if(!empty($data['id']))
        {
            return $this->database->table('brands')
                ->where('id', $data['id'])
                ->update([
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]);
        }

        return $this->database->table('brands')->insert([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        
    }

    public function delete(int $id) : int
    {
        //some validation ot other magic in real life app

        return $this->database->table('brands')
            ->where('id', $id)
            ->delete();
    }
}