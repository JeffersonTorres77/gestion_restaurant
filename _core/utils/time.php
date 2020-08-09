<?php
	/*==================================================
	 * Time
	==================================================*/
	class Time
	{
		/*==============================================
		 * 
		==============================================*/
		public static function get($ajuste_hora = -6, $ajuste_minutos = 0)
		{
			//Iniciamos la hora con ajuste
			$horas = date('H') + $ajuste_hora;
			$minutos = date('i') + $ajuste_minutos;
			$segundos = date('s');

			//Iniciamos la fecha
			$año = date("Y");
			$mes = date("m");
			$dia = date("d");

			//Aplicamos ajuste
			if($minutos >= 60)
			{
				$minutos -= 60;
				$horas += 1;
			}

			if($horas < 0)
			{
				$horas += 24;
				$dia -= 1;
			}

			//Arreglamos la salida
			$t['fecha']['año'] = $año;
			$t['fecha']['mes'] = $mes;
			$t['fecha']['dia'] = $dia;
			$t['hora']['horas'] = $horas;
			$t['hora']['minutos'] = $minutos;
			$t['hora']['segundos'] = $segundos;

			//Arreglamos los digitos
			foreach($t['fecha'] as $key => $value)
			{
				if(strlen($value) < 2)
				{
					$t[$key] = "0".$value;
				}
			}

			foreach($t['hora'] as $key => $value)
			{
				if(strlen($value) < 2)
				{
					$t[$key] = "0".$value;
				}
            }
            
            $time = $t['fecha']['año']."-".$t['fecha']['mes']."-".$t['fecha']['dia'];
            $time .= " ";
            $time .= $t['hora']['horas'].":".$t['hora']['minutos'].":".$t['hora']['segundos'];

			//Retornamos
			return $time;
		}
	}
?>