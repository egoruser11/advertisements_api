<?php


namespace App\Http\Services;

use App\Models\Advertisement;

class AdvertisementStoreService
{
    public function run(array $data): Advertisement
    {
        $advertisement = Advertisement::create(collect($data)->except(['params'])->all());
        if (!empty($data['params'])) {
            $params = [];
            foreach ($data['params'] as $param) {
                $params[$param['id']] = ['value' => $param['value']];
            }
            $advertisement->params()->attach($params);
        }
        return $advertisement;
    }

}


