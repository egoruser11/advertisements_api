<?php


namespace App\Http\Services;

use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;

class AdvertisementUpdateService
{
    public function run(array $data): Advertisement
    {
        $advertisement = Advertisement::findOrFail($data['id']);
        return DB::transaction(function () use ($advertisement, $data) {
            $advertisement->update(collect($data)->except(['params'])->all());
            if (!empty($data['params'])) {
                $params = [];
                foreach ($data['params'] as $param) {
                    $params[$param['id']] = ['value' => $param['value']];
                }
                $advertisement->params()->sync($params);
            }
            $advertisement->load('params');
            return $advertisement;
        });

    }

}


