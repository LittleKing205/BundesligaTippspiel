<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    static public $settings = null;

    protected $table = 'settings';

    protected $fillable = [
        "key",
        "value",
        "type"
    ];

    static function get($key, $default = null) {
        if(empty(self::$settings)) {
            self::$settings = self::all();
        }
        $model = self::$settings->where('key', $key)->first();
        if (empty($model)) {
            if (!empty($default) || is_bool($default)) {
                return $default;
            } else {
                throw new \Exception('Cannot find setting: '.$key);
            }
        } else {
            return $model->value;
        }
    }

    static function set(string $key, $value, $type = null) {
        if (empty(self::$settings)) {
            self::$settings == self::all();
        }
        if (is_string($value) || is_int($value) || is_bool($value)) {
            $model = self::$settings->where('key', $key)->first();
            if (empty($model)) {
                $model = self::create([
                    'key' => $key,
                    'value' => $value,
                    'type' => $type
                ]);
                self::$settings->push($model);
            } else {
                $model->update(compact('value'));
            }
            return true;
        } else {
            return false;
        }
    }
}
