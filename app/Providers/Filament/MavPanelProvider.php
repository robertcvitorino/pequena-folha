<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;

class MavPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('mav')
            ->path('mav')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->brandLogo( asset('image/logo.png') )
            ->favicon( asset('image/logo.png') )
            ->brandName( 'Mav' )
            ->darkModeBrandLogo(asset('image/logo_dark_mode.png'))
            ->brandLogoHeight( '60px' )
            ->discoverResources(in: app_path('Filament/Mav/Resources'), for: 'App\\Filament\\Mav\\Resources')
            ->discoverPages(in: app_path('Filament/Mav/Pages'), for: 'App\\Filament\\Mav\\Pages')
            ->pages([
            ])
            ->plugins([
                FilamentBackgroundsPlugin::make()
                    ->imageProvider(
                        MyImages::make()
                            ->directory('image/background')),
            ])
            ->discoverWidgets(in: app_path('Filament/Mav/Widgets'), for: 'App\\Filament\\Mav\\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
