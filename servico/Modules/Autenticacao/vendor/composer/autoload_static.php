<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbbe1a6c03bc7a450d6f4ffcd733c04af
{
    public static $prefixLengthsPsr4 = array(
        'M' =>
            array(
                'Modules\\Autenticacao\\' => 21,
            ),
    );

    public static $prefixDirsPsr4 = array(
        'Modules\\Autenticacao\\' =>
            array(
                0 => __DIR__ . '/../..' . '/',
            ),
    );

    public static $classMap = array(
        'Modules\\Autenticacao\\Database\\Seeders\\AutenticacaoDatabaseSeeder' => __DIR__ . '/../..' . '/Database/Seeders/AutenticacaoDatabaseSeeder.php',
        'Modules\\Autenticacao\\Entities\\Usuario' => __DIR__ . '/../..' . '/Entities/Usuario.php',
        'Modules\\Autenticacao\\Enums\\Cargo' => __DIR__ . '/../..' . '/Enums/Cargo.php',
        'Modules\\Autenticacao\\Enums\\UsuarioPerfil' => __DIR__ . '/../..' . '/Enums/UsuarioPerfil.php',
        'Modules\\Autenticacao\\Exceptions\\CargoInvalidoException' => __DIR__ . '/../..' . '/Exceptions/CargoInvalidoException.php',
        'Modules\\Autenticacao\\Exceptions\\ContaInativaException' => __DIR__ . '/../..' . '/Exceptions/ContaInativaException.php',
        'Modules\\Autenticacao\\Exceptions\\CredenciaisInvalidasException' => __DIR__ . '/../..' . '/Exceptions/CredenciaisInvalidasException.php',
        'Modules\\Autenticacao\\Exceptions\\DataCargoVigenciaException' => __DIR__ . '/../..' . '/Exceptions/DataCargoVigenciaException.php',
        'Modules\\Autenticacao\\Exceptions\\NenhumaAcaoAssociadaPerfilException' => __DIR__ . '/../..' . '/Exceptions/NenhumaAcaoAssociadaPerfilException.php',
        'Modules\\Autenticacao\\Exceptions\\ServicoSAAException' => __DIR__ . '/../..' . '/Exceptions/ServicoSAAException.php',
        'Modules\\Autenticacao\\Exceptions\\UsuarioNaoResponsavelPorOrgaoException' => __DIR__ . '/../..' . '/Exceptions/UsuarioNaoResponsavelPorOrgaoException.php',
        'Modules\\Autenticacao\\Exceptions\\UsuarioSemPermissaoException' => __DIR__ . '/../..' . '/Exceptions/UsuarioSemPermissaoException.php',
        'Modules\\Autenticacao\\Http\\Controllers\\AutenticacaoController' => __DIR__ . '/../..' . '/Http/Controllers/AutenticacaoController.php',
        'Modules\\Autenticacao\\Http\\Requests\\AuthRequest' => __DIR__ . '/../..' . '/Http/Requests/AuthRequest.php',
        'Modules\\Autenticacao\\Providers\\AutenticacaoServiceProvider' => __DIR__ . '/../..' . '/Providers/AutenticacaoServiceProvider.php',
        'Modules\\Autenticacao\\Providers\\RouteServiceProvider' => __DIR__ . '/../..' . '/Providers/RouteServiceProvider.php',
        'Modules\\Autenticacao\\Providers\\SaaUserProvider' => __DIR__ . '/../..' . '/Providers/SaaUserProvider.php',
        'Modules\\Autenticacao\\Repository\\DirigenciaRepository' => __DIR__ . '/../..' . '/Repository/DirigenciaRepository.php',
        'Modules\\Autenticacao\\Service\\CadSuas' => __DIR__ . '/../..' . '/Service/CadSuas.php',
        'Modules\\Autenticacao\\Service\\Saa' => __DIR__ . '/../..' . '/Service/Saa.php',
        'Modules\\Autenticacao\\Tests\\Feature\\AutenticacaoControllerTest' => __DIR__ . '/../..' . '/Tests/Feature/AutenticacaoControllerTest.php',
        'Modules\\Autenticacao\\Tests\\Unit\\Service\\SAATest' => __DIR__ . '/../..' . '/Tests/Unit/Service/SAATest.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbbe1a6c03bc7a450d6f4ffcd733c04af::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbbe1a6c03bc7a450d6f4ffcd733c04af::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbbe1a6c03bc7a450d6f4ffcd733c04af::$classMap;

        }, null, ClassLoader::class);
    }
}