<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Zoom()
 * @method static static GoogleMeet()
 * @method static static MicrosoftTeams()
 * @method static static Other()
 */
final class EventMethod extends Enum
{
    const Zoom = 'zoom';
    const GoogleMeet = 'google_meet';
    const MicrosoftTeams = 'microsoft_teams';
    const Other = 'other';

    public function label($locale = null): string
    {
        return __("enums.event_method.{$this->value}", [], $locale);
    }

    public function description($locale = null): string
    {
        return __("enums.event_method_message.{$this->value}", [], $locale);
    }

    public function isZoom(): bool
    {
        return $this->value === self::Zoom;
    }
    public function isGoogleMeet(): bool
    {
        return $this->value === self::GoogleMeet;
    }
    public function isMicrosoftTeams(): bool
    {
        return $this->value === self::MicrosoftTeams;
    }
    public function isOther(): bool
    {
        return $this->value === self::Other;
    }

    public function color(): string
    {
        return match ($this->value) {
            self::Zoom => '#2563EB',          
            self::GoogleMeet => '#16A34A',    
            self::MicrosoftTeams => '#7C3AED', 
            self::Other => '#6B7280',        
            default => '#6B7280',
        };
    }


    public function icon()
    {
        return match ($this->value) {
            self::Zoom => 'zoom',
            self::GoogleMeet => 'meet',
            self::MicrosoftTeams => 'microsoftteams',
            self::Other => 'video',
            default => 'question',
        };
    }
}
