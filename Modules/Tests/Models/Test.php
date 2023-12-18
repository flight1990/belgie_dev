<?php

namespace Modules\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Tests\Database\factories\TestFactory;
use Modules\Users\Models\User;
use Modules\Operators\Models\Operator;
use Modules\Standards\Models\Standard;
use Modules\ConnectionTypes\Models\ConnectionType;
use Modules\Servers\Models\Server;
use Modules\Towers\Models\Tower;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
       'x',
       'y',
        'distance',
        'max_speed_download',
        'medium_speed_download',
        'max_speed_upload',
        'min_speed_upload',
        'max_ping',
        'medium_ping',
        'time_start',
        'time_download_web_1',
        'time_download_web_2',
        'time_download_web_3',
        'loss_ping',
        'model_phone',
        'version_os',
        'level_signal',
        'address_site_1',
        'address_site_2',
        'address_site_3',
        'address_youtube',
        'screen_resolution',
        'load_web_1',
        'load_web_2',
        'load_web_3',
        'data_used',
        'complaint',
        'is_room',
        'operator_id',
        'standard_id',
        'connection_type_id',
        'server_id',
        'tower_id',
        'user_id',
        'band',
        'sector',
    ];

    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function standard(): BelongsTo
    {
        return $this->belongsTo(Standard::class);
    }

    public function connectionType(): BelongsTo
    {
        return $this->belongsTo(ConnectionType::class);
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function tower(): BelongsTo
    {
        return $this->belongsTo(Tower::class);
    }
}
