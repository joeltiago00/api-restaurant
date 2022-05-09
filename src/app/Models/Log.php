<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Throwable;

class Log extends Model
{
    use SoftDeletes;

    protected $table = 'logging';

    protected $fillable = [
        'error_code', 'level', 'message', 'trace'
    ];

    /**
     * @param Throwable $e
     * @param string $level
     * @return string
     * @throws Exception
     */
    public static function generate(Throwable $e, string $level): string
    {
        try {
            if (!$log = Log::create([
                'error_code' => Str::uuid()->toString(),
                'level' => $level,
                'message' => json_encode($e->getMessage()),
                'trace' => json_encode($e->getTraceAsString())
            ]))
                throw new Exception($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $log->error_code;
    }
}
