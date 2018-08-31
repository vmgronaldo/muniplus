<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use App\Program;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{

    public function index()
    {
        $schedules = DB::table('schedules')
                    ->OrderBy('nombre','asc')
                    ->get();

        return $schedules;
    }


    public function store(Request $request)
    {
        if(count($request->HorarioLunes) % 2 == 0 && count($request->HorarioMartes) % 2 == 0 && count($request->HorarioMiercoles) % 2 == 0 && count($request->HorarioJueves) % 2 == 0 && count($request->HorarioViernes) % 2 == 0 && count($request->HorarioSabado) % 2 == 0 && count($request->HorarioDomingo) % 2 == 0)
        {
            // Agregar Horario
            $horario = new Schedule();
            $horario->nombre  = $request->nombre;
            $horario->save();
            // Agregar programas del horario
            for ($i = 1; $i <= 7; $i++) {
                switch (count($request->todos[$i - 1])) {
                    case 0:
                        break;
                    case 2:
                        $program = new Program();
                        $program->entrada1 = $request->todos[$i - 1][0];
                        $program->salida1 = $request->todos[$i - 1][1];
                        $program->dia_id = $i;
                        $program->schedule_id = $horario->id;
                        $program->save();
                        break;
                    case 4:
                        $program = new Program();
                        $program->entrada1 = $request->todos[$i - 1][0];
                        $program->salida1 = $request->todos[$i - 1][1];
                        $program->entrada2 = $request->todos[$i - 1][2];
                        $program->salida2 = $request->todos[$i - 1][3];
                        $program->dia_id = $i;
                        $program->schedule_id = $horario->id;
                        $program->save();
                        break;
                    default:
                        break;
                }
            }
            $horario->save = true;
            return $horario;
        }
        $horario->save = false;
        return $horario;
    }


    public function findPrograms($id)
    {
        $programs = DB::table('programs')
            ->where('schedule_id',$id)
            ->get();

        return $programs;
    }


    public function update(Request $request, $id)
    {
        if(count($request->HorarioLunes) % 2 == 0 && count($request->HorarioMartes) % 2 == 0 && count($request->HorarioMiercoles) % 2 == 0 && count($request->HorarioJueves) % 2 == 0 && count($request->HorarioViernes) % 2 == 0 && count($request->HorarioSabado) % 2 == 0 && count($request->HorarioDomingo) % 2 == 0)
        {
            // Agregar Horario
            $horario = Schedule::find($id);
            $horario->nombre  = $request->nombre;
            $horario->save();
            //Eliminar programas del hoarrio
            $programs = findPrograms($id);
            $programs->delete();
            // Agregar programas del horario
            for ($i = 1; $i <= 7; $i++) {
                switch (count($request->todos[$i - 1])) {
                    case 0:
                        break;
                    case 2:
                        $program = new Program();
                        $program->entrada1 = $request->todos[$i - 1][0];
                        $program->salida1 = $request->todos[$i - 1][1];
                        $program->dia_id = $i;
                        $program->schedule_id = $horario->id;
                        $program->save();
                        break;
                    case 4:
                        $program = new Program();
                        $program->entrada1 = $request->todos[$i - 1][0];
                        $program->salida1 = $request->todos[$i - 1][1];
                        $program->entrada2 = $request->todos[$i - 1][2];
                        $program->salida2 = $request->todos[$i - 1][3];
                        $program->dia_id = $i;
                        $program->schedule_id = $horario->id;
                        $program->save();
                        break;
                    default:
                        break;
                }
            }
            $horario->save = true;
            return $horario;
        }
        $horario->save = false;
        return $horario;
    }

    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        $schedule->delete();
    }
}
