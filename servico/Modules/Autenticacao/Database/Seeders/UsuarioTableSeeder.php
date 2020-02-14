<?php

namespace Modules\Autenticacao\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Adesao\Entities\Servidor;
use Modules\Autenticacao\Entities\Usuario;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servidor::all()
            ->each(function (Servidor $servidor) {
               Usuario::updateOrCreate([Usuario::NU_CPF => $servidor->nu_cpf],[
                    Usuario::NO_USUARIO => $servidor->no_servidor,
                    Usuario::NU_CPF => $servidor->nu_cpf,
                    Usuario::DS_EMAIL => $servidor->ds_email,
                    Usuario::TP_PERFIL => 'E',
                    Usuario::DS_SENHA => 123456
                ]);
            });

        Usuario::updateOrCreate([Usuario::NU_CPF => '89159680008'],[
            Usuario::NO_USUARIO => 'Teste Servidor Interno 1',
            Usuario::NU_CPF => '89159680008',
            Usuario::DS_EMAIL => 'teste@teste.com',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '27147896092'],[
            Usuario::NO_USUARIO => 'Teste Servidor Interno 2',
            Usuario::NU_CPF => '27147896092',
            Usuario::DS_EMAIL => 'teste2@teste.com',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '01150516194'],[
            Usuario::NO_USUARIO => 'Ciro',
            Usuario::NU_CPF => '01150516194',
            Usuario::DS_EMAIL => 'ciro.junior@basis.com.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '72407409191'],[
            Usuario::NO_USUARIO => 'Janilson',
            Usuario::NU_CPF => '72407409191',
            Usuario::DS_EMAIL => 'janilson.silva@basis.com.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '71450793134'],[
            Usuario::NO_USUARIO => 'MARIA TEREZA MATOS BEZERRA',
            Usuario::NU_CPF => '71450793134',
            Usuario::DS_EMAIL => 'maria.matos@terceirizado.cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '73772291104'],[
            Usuario::NO_USUARIO => 'MUNIQUE REIS BRAZ COUTINHO',
            Usuario::NU_CPF => '73772291104',
            Usuario::DS_EMAIL => 'munique.coutinho@terceirizado.cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '17261709859'],[
            Usuario::NO_USUARIO => 'MARCO ANDRÉ DE OLIVEIRA PEDRO GARBELOTTI',
            Usuario::NU_CPF => '17261709859',
            Usuario::DS_EMAIL => 'marco.garbelotti@cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '36319105120'],[
            Usuario::NO_USUARIO => 'AUGUSTO LIRA DA ROCHA',
            Usuario::NU_CPF => '36319105120',
            Usuario::DS_EMAIL => 'augusto.rocha@cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '01405504706'],[
            Usuario::NO_USUARIO => 'MARCOS DE SOUZA E SILVA',
            Usuario::NU_CPF => '01405504706',
            Usuario::DS_EMAIL => 'marcos.ssilva@cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '01793678111'],[
            Usuario::NO_USUARIO => 'TERESA AMÉLIA ARRUDA BARROSO',
            Usuario::NU_CPF => '01793678111',
            Usuario::DS_EMAIL => 'teresa.barros@cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '36989141824'],[
            Usuario::NO_USUARIO => 'VANESSA DE SOUZA LANZA',
            Usuario::NU_CPF => '36989141824',
            Usuario::DS_EMAIL => 'vanessa.lanza@cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '72927330182'],[
            Usuario::NO_USUARIO => 'LUCAS COSTA DE CARVALHO DIAS',
            Usuario::NU_CPF => '72927330182',
            Usuario::DS_EMAIL => 'lucas.dias@terceirizado.cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);

        Usuario::updateOrCreate([Usuario::NU_CPF => '11373373709'],[
            Usuario::NO_USUARIO => 'IKE GONÇALVES JAVARINE FERREIRA',
            Usuario::NU_CPF => '11373373709',
            Usuario::DS_EMAIL => 'ike.ferreira@cidadania.gov.br',
            Usuario::TP_PERFIL => 'I',
            Usuario::DS_SENHA => 123456
        ]);
    }
}
