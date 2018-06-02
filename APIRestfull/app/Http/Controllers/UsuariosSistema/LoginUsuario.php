<?php

namespace App\Http\Controllers\UsuariosSistema;

use App\Enfermeras;
use App\Http\Controllers\ApiController;
use App\Medicos;
use App\Pacientes;
use App\User;
use Illuminate\Http\Request;

class LoginUsuario extends ApiController
{
    
    public function loginUsuario($email){

        $Usuario =  User::where("email", "=",$email)->get();

        foreach ($Usuario as $dato) {
            $user =(object) array(
                'email'           => empty($dato->email) ? '': $dato->email, 
                'idMedico'        => empty($dato->idMedico) ? '': $dato->idMedico, 
                'idEnfermera'     => empty($dato->idEnfermera) ? '': $dato->idEnfermera, 
                'idPaciente'      => empty($dato->idPaciente) ? '': $dato->idPaciente, 
                'idTipo_usuario'  => empty($dato->idTipo_usuario) ? '': $dato->idTipo_usuario, 
                'idCentro_medico' => empty($dato->idCentro_medico) ? '': $dato->idCentro_medico, 
            );          
        }
        if(empty($user->email)){
            return $this->errorResponse('Datos no encontrados', 500);
        }

        if($user->idMedico != 1)
            $infoUsuario = Medicos::findOrFail($user->idMedico);

        if($user->idEnfermera != 1)
            $infoUsuario = Enfermeras::findOrFail($user->idEnfermera);

        if($user->idPaciente != 1)
            $infoUsuario = Pacientes::findOrFail($user->idPaciente);


        $respuesta = array(
            'Usuario'      => $infoUsuario,
            'Menu'         => $this->getMenu($user->idTipo_usuario),
        );

        return $this->showList($respuesta);
    }

    public function getMenu($permiso){


        switch ($permiso) {
            case $permiso == User::SUPERADMIN:
                $menu = "{titulo:'Inicio',icono:'zmdi zmdi-home',submenu:[{titulo:'Dashboard',url:'/dashboard'}]}";
            break;

            case User::MEDICO:
                $menu = "{titulo:'Medicos',icono:'zmdi zmdi-account-add',submenu:[{titulo:'Listar Medicos',url:'/medicos'},{titulo:'Agregar Medico',url:'/agregar-medico'}]}";
            break;

            case User::ENFERMERA:
                $menu = "{titulo:'Enfermeras',icono:'zmdi zmdi-account-add',submenu:[{titulo: 'Listar Enfermeras',url:'/enfermeras'},{titulo:'Agregar Enfermeras',url:'/agregar-enfermera'}]}";
            break;

            case User::ADMINISTRADOR:
                $menu = "{titulo:'Infraestructura',icono:'zmdi zmdi-account-add',submenu:[{titulo:'Agregar piso',url:'/agregar-piso'},{titulo:'Agregar seccion',url:'/agregar-seccion'},{titulo:'Listar pisos',url:'/pisos'},{titulo:'Listar secciones',url:'/secciones'},]}";
            break;

            case User::PACIENTE:
                $menu = "{titulo:'Pacientes',icono:'zmdi zmdi-account-add',submenu:[{titulo:'Listar pacientes', url:'/pacientes'},{titulo:'Agregar pacientes',url:'/agregar-paciente'}]}";
            break;

            case User::CAJERO:
                $menu = "{titulo:'Consulta',icono:'zmdi zmdi-account-add',submenu:[{titulo:'Citas',url:'/cita'},{titulo:'Historia clinica',url:'/historia-clinica'},{titulo: 'Estudios y resultados',url:'/estudios'},{titulo:'Notas',url:'/notas'},{titulo:'Cuadro clinico',url:'/cuadro-clinico'},{titulo:'Recetas de medicamentos',url:'/recetas-medicamentos'},{titulo: 'Somatometría',url:'/somatometria'},{titulo:'Alergias',url:'/alergias'},{titulo:'Cartilla de vacunación',url:'/cartilla-vacunacion'},{titulo:'Diagnnosticos',url:'/diagnosticos'},]}";
            break;
        }
        return $menu;
    }
}