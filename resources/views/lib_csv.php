<?php

	function revisa_anulacion($numero_documento,$tipo_documento,$detalle_solicitud)
	{
		//
		$cantidad_articulos = count($detalle_solicitud);

		$busca_detalle_venta = new Consulta("SELECT * from detalleventa WHERE NUMERO='$numero_documento' and TIPODOCTO='$tipo_documento' and Tipo='Electronica'");

		if($busca_detalle_venta->filas_resultado()==$cantidad_articulos)
		{
			$busca_articulo = new Consulta();
			foreach ($detalle_solicitud as $key => $value) {
				$busca_articulo->cambiar_consulta("SELECT * from detalleventa WHERE NUMERO='$numero_documento' and TIPODOCTO='$tipo_documento' and Tipo='Electronica' and COD_ART1='{$value['codigo']}'");
				if($busca_articulo->filas_resultado()>0)
				{
					//
					$respuesta_articulo = $busca_articulo->resultado_arreglo();
					if($value['cantidad']!=$respuesta_articulo[0]['CANTIDAD'])
					{
						return false;
					}
				}else{
					return false;
				}
			}
			return true;
		}
		return false;
	}

	function obtener_medio_pago($medio)
	{
		//
	}

	function retorna_cabezera($csv_sep,$csv_end){
		//
		$csv 		=	"";  
	 
		$csv.='"TIPO (33: Factura electrónica, 34:Factura exenta electrónica, 46: Factura de compra electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 39: Boleta electrónica; 41: Boleta exenta electrónica )"'.$csv_sep;
		$csv.='FOLIO'.$csv_sep;
		$csv.='SECUENCIA'.$csv_sep;
		$csv.='FECHA'.$csv_sep;
		$csv.='RUT'.$csv_sep;
		$csv.='RAZONSOCIAL'.$csv_sep;
		$csv.='GIRO'.$csv_sep;
		$csv.='COMUNA'.$csv_sep;
		$csv.='DIRECCION'.$csv_sep;
		$csv.='AFECTO'.$csv_sep;
		$csv.='PRODUCTO'.$csv_sep;
		$csv.='DESCRIPCION'.$csv_sep;
		$csv.='CANTIDAD'.$csv_sep;
		$csv.='PRECIO'.$csv_sep;
		$csv.='PORCENTDSCTO'.$csv_sep;
		$csv.='EMAIL'.$csv_sep;
		$csv.='"TIPOSERVICIO (1: Boletas de servicios periódico ó Facturas de servicios periódicos domiciliarios; 2:Boletas de servicios periódicos domiciliarios ó Facturas de otros servicios periódicos; 3:Boletas de venta y servicios ó Factura de servicios)"'.$csv_sep;
		$csv.='PERIODODESDE'.$csv_sep;
		$csv.='PERIODOHASTA'.$csv_sep;
		$csv.='FECHAVENCIMIENTO'.$csv_sep;
		$csv.='CODSUCURSAL'.$csv_sep;
		$csv.='VENDEDOR'.$csv_sep;
		$csv.='CODRECEPTOR'.$csv_sep;
		$csv.='CODITEM'.$csv_sep;
		$csv.='UNIDADMEDIDA(HR,KG,MR,PM,PP,QTAL,TBDM,TBDU,TON,UNID)'.$csv_sep;
		$csv.='PORCENTDSCTO2'.$csv_sep;
		$csv.='PORCENTDSCTO3'.$csv_sep;
		$csv.='CODIGOIMP'.$csv_sep;
		$csv.='MONTOIMP'.$csv_sep;
		$csv.='INDICADORTRASLADO(1:Operacion constituye venta,2:Ventas por efectuar,3:Consignaciones,4:Entrega gratuita,5:Traslados internos,6:Otros traslados no venta,7:Guia de devolucion)'.$csv_sep;
		$csv.='FORMAPAGO(1:Contado, 2:Credito, 3:Sin costo)'.$csv_sep;
		$csv.='MEDIOPAGO(CH:Cheque,CF:Cheque a fecha,LT:letra,EF:Efectivo,PE:Pago a cta.cte,TC:Tarjeta Credito,OT:Otro)'.$csv_sep;
		$csv.='TERMINOSPAGOSDIAS'.$csv_sep;
		$csv.='TERMINOSPAGOCODIGO'.$csv_sep;
		$csv.='COMUNADESTINO'.$csv_sep;
		$csv.='RUTSOLICITANTEFACTURA'.$csv_sep;
		$csv.='PRODUCTOCAMBIOSUJETO'.$csv_sep;
		$csv.='CANTIDADMONTOCAMBIOSUJETO'.$csv_sep;
		$csv.=' TIPOGLOBALAFECTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)'.$csv_sep;
		$csv.='VALORGLOBALAFECTO'.$csv_sep;
		$csv.='TIPOGLOBALEXENTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)'.$csv_sep;
		$csv.='VALORGLOBALEXENTO'.$csv_sep.$csv_end;

		return $csv;
	}

	function csv_nota($datos_solicitud,$detalle_solicitud,$datos_cliente,$datos_venta,$folio)
	{
		$identificador = "61";

$csv_end 	= 	"
";  
		$csv_sep 	= 	";";  
		
		$csv = retorna_cabezera($csv_sep,$csv_end);

	    $contador		=	1;

	    foreach ($datos_solicitud as $key => $value)
		{
			//
			$forma_pago="1";

			if($datos_venta[0]["PAGO"] == "CREDITO")
			{
				$forma_pago ="2";
			}

			$medio_pago = obtener_medio_pago($datos_venta[0]["PAGO"]);

	        //$folio 				=	$row_v['FOLIO'];
	        $rutsinpunto 		= 	str_replace (".", "", $datos_venta[0]['RUT']);
	        $rutsinpunto		=	ltrim($rutsinpunto,"0");
            $nombreclie=utf8_encode($datos_cliente[0]['NOMBRE']);
            $giro=utf8_encode($datos_cliente[0]['GIRO']);
	        $comuna=utf8_encode($datos_cliente[0]['COMUNA']);
	        $direccion=utf8_encode($datos_cliente[0]['DIRECCION']);
	        $email=$datos_cliente[0]['EMAIL'];

	        $hoy = date("Y-m-d");
	        
	        $lafecha=explode("-",$hoy);
	        $fecha_formateada= $lafecha['2']."/".$lafecha['1']."/".$lafecha['0'];

	        foreach ($detalle_solicitud as $clave => $valor) {
		        //sacar neto
		        $valor_unitario 	= $valor['subtotal']/$valor['cantidad'];

		        $valor_neto 		= round($valor_unitario/1.19);

				$csv.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura exenta electrónica, 46: Factura de compra electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 39: Boleta electrónica; 41: Boleta exenta electrónica )
				$csv.=$folio.$csv_sep;//FOLIO
				$csv.=$contador.$csv_sep;//SECUENCIA
				$csv.=$fecha_formateada.$csv_sep;//FECHA
				$csv.=$rutsinpunto.$csv_sep;//RUT
				$csv.=$nombreclie.$csv_sep;//RAZONSOCIAL
				$csv.=$giro.$csv_sep;//GIRO
				$csv.=$comuna.$csv_sep;//COMUNA
				$csv.=$direccion.$csv_sep;//DIRECCION
				$csv.='SI'.$csv_sep;//AFECTO
				$csv.=$valor['descripcion'].$csv_sep;//PRODUCTO
				$csv.=''.$csv_sep;//DESCRIPCION
				$csv.=$valor['cantidad'].$csv_sep;//CANTIDAD	
				$csv.=$valor_neto.$csv_sep;//PRECIO
				//$csv.=$row['DESCUENTO'].$csv_sep;//PORCENTDSCTO
				$csv.='0'.$csv_sep;//PORCENTDSCTO
				$csv.=$email.$csv_sep;//EMAIL
				$csv.=''.$csv_sep;//TIPOSERVICIO (1: Boletas de servicios periódico ó Facturas de servicios periódicos domiciliarios; 2:Boletas de servicios periódicos domiciliarios ó Facturas de otros servicios periódicos; 3:Boletas de venta y servicios ó Factura de servicios)
				$csv.=''.$csv_sep;//PERIODODESDE
				$csv.=''.$csv_sep;//PERIODOHASTA
				$csv.=''.$csv_sep;//FECHAVENCIMIENTO
				$csv.='1'.$csv_sep;//CODSUCURSAL
				$csv.=$datos_venta[0]['VENDEDOR'].$csv_sep;//VENDEDOR
				$csv.=''.$csv_sep;//CODRECEPTOR
				$csv.=$valor['codigo'].$csv_sep;/*CODITEM*/
				$csv.=''.$csv_sep;//UNIDADMEDIDA(HR,KG,MR,PM,PP,QTAL,TBDM,TBDU,TON,UNID)
				$csv.=''.$csv_sep;//PORCENTDSCTO2
				$csv.=''.$csv_sep;//PORCENTDSCTO3
				$csv.=''.$csv_sep;//CODIGOIMP
				$csv.=''.$csv_sep;//MONTOIMP
				$csv.=''.$csv_sep;//INDICADORTRASLADO(1:Operacion constituye venta,2:Ventas por efectuar,3:Consignaciones,4:Entrega gratuita,5:Traslados internos,6:Otros traslados no venta,7:Guia de devolucion)
				$csv.=$forma_pago.$csv_sep;//FORMAPAGO(1:Contado, 2:Credito, 3:Sin costo)
				$csv.=$medio_pago.$csv_sep;//MEDIOPAGO(CH:Cheque,CF:Cheque a fecha,LT:letra,EF:Efectivo,PE:Pago a cta.cte,TC:Tarjeta Credito,OT:Otro)
				$csv.=''.$csv_sep;//TERMINOSPAGOSDIAS
				$csv.=''.$csv_sep;//TERMINOSPAGOCODIGO
				$csv.=''.$csv_sep;//COMUNADESTINO
				$csv.=''.$csv_sep;//RUTSOLICITANTEFACTURA
				$csv.=''.$csv_sep;//PRODUCTOCAMBIOSUJETO
				$csv.=''.$csv_sep;//CANTIDADMONTOCAMBIOSUJETO
				$csv.=''.$csv_sep;//TIPOGLOBALAFECTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
				$csv.=''.$csv_sep;//VALORGLOBALAFECTO	
				$csv.=''.$csv_sep;//TIPOGLOBALEXENTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
				$csv.=''.$csv_end;//VALORGLOBALEXENTO

				$contador++;

			}
			$csv=trim($csv);
			  
			$csv_file 	= 	"notas_csv/nota_".$folio.".csv";
			//Generamos el csv de todos los datos  
			if (!$handle = fopen($csv_file, "w")) {  
			    return "Cannot open file";  
			    //exit;  
			}  
			if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
			    return "Cannot write to file";  
			    //exit;  
			}  
			fclose($handle);

			//return "Archivo Creado";

			//
			$csv_ref = "";

			$csv_ref.="TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)".$csv_sep;
			$csv_ref.="FOLIO".$csv_sep;
			$csv_ref.="SECUENCIA".$csv_sep;
			$csv_ref.="TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)".$csv_sep;
			$csv_ref.="FOLIO DOCUMENTO REFERENCIADO".$csv_sep;
			$csv_ref.="FECHA DOCUMENTO REFERENCIADO".$csv_sep;
			$csv_ref.="MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)".$csv_sep;
			$csv_ref.="GLOSA REFERENCIA".$csv_sep.$csv_end;

			$referencias 	= false;
			$contador_ref	= 0;

			$contador_ref++;
			$referencias = true;

			$identificador_ref = "33";

			if($datos_venta[0]['TDOCTO']=='BOLETA')
			{
				$identificador_ref = "39";
			}

			$fecha_doc=explode("-",$datos_venta[0]['FECHA']);
	        $fecha_formateada_ref= $fecha_doc['2']."/".$fecha_doc['1']."/".$fecha_doc['0'];

	        $anula_documento = revisa_anulacion($datos_venta[0]['FOLIO'],$datos_venta['TDOCTO'],$detalle_solicitud);

			$csv_ref.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)			
			$csv_ref.=$folio.$csv_sep;//FOLIO
			$csv_ref.=$contador_ref.$csv_sep;//SECUENCIA
			$csv_ref.=$identificador_ref.$csv_sep;//TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)
			$csv_ref.=$datos_venta[0]['FOLIO'].$csv_sep;//FOLIO DOCUMENTO REFERENCIADO
			$csv_ref.=$fecha_formateada_ref.$csv_sep;//FECHA DOCUMENTO REFERENCIADO
			if($anula_documento)
			{
				$csv_ref.="1".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
			}else{
				$csv_ref.="3".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
			}
			//$csv_ref.="".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
			$csv_ref.=$datos_solicitud[0]['usonota'].$csv_end;//GLOSA REFERENCIA


		
			if($referencias == true)
			{
				$csv_ref=trim($csv_ref);
			  
				$csv_file_ref 	= 	"ref_facturas_csv/nota_".$folio.".csv";
				//Generamos el csv de todos los datos  
				if (!$handle2 = fopen($csv_file_ref, "w")) {  
				    return "Cannot open file";  
				    exit;  
				}  
				if (fwrite($handle2, utf8_decode($csv_ref)) === FALSE) {  
				    return "Cannot write to file";  
				    exit;  
				}  
				fclose($handle2);
			}

			return "Archivo Creado";

		}
	}

	function csv_nota_descuento($datos_cliente,$datos_venta,$folio,$rut,$fpago,$valor,$porcentaje)
	{
		$identificador = "61";

$csv_end 	= 	"
";  
		$csv_sep 	= 	";";  
		
		$csv = retorna_cabezera($csv_sep,$csv_end);

	    $contador		=	1;

    
		//
		$forma_pago="1";

		if($fpago == "CREDITO")
		{
			$forma_pago ="2";
		}

		$medio_pago = obtener_medio_pago($datos_venta[0]["PAGO"]);

        //$folio 				=	$row_v['FOLIO'];
        $rutsinpunto 		= 	str_replace (".", "", $rut);
        $rutsinpunto		=	ltrim($rutsinpunto,"0");
        $nombreclie=utf8_encode($datos_cliente[0]['NOMBRE']);
        $giro=utf8_encode($datos_cliente[0]['GIRO']);
        $comuna=utf8_encode($datos_cliente[0]['COMUNA']);
        $direccion=utf8_encode($datos_cliente[0]['DIRECCION']);
        $email=$datos_cliente[0]['EMAIL'];

        $hoy = date("Y-m-d");
        
        $lafecha=explode("-",$hoy);
        $fecha_formateada= $lafecha['2']."/".$lafecha['1']."/".$lafecha['0'];

        
        //sacar neto
        $valor_unitario 	= $valor;

        $valor_neto 		= round($valor_unitario/1.19);

		$csv.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura exenta electrónica, 46: Factura de compra electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 39: Boleta electrónica; 41: Boleta exenta electrónica )
		$csv.=$folio.$csv_sep;//FOLIO
		$csv.=$contador.$csv_sep;//SECUENCIA
		$csv.=$fecha_formateada.$csv_sep;//FECHA
		$csv.=$rutsinpunto.$csv_sep;//RUT
		$csv.=$nombreclie.$csv_sep;//RAZONSOCIAL
		$csv.=$giro.$csv_sep;//GIRO
		$csv.=$comuna.$csv_sep;//COMUNA
		$csv.=$direccion.$csv_sep;//DIRECCION
		$csv.='SI'.$csv_sep;//AFECTO
		$csv.="Descuento $porcentaje %".$csv_sep;//PRODUCTO
		$csv.=''.$csv_sep;//DESCRIPCION
		$csv.="1".$csv_sep;//CANTIDAD	
		$csv.=$valor_neto.$csv_sep;//PRECIO
		//$csv.=$row['DESCUENTO'].$csv_sep;//PORCENTDSCTO
		$csv.='0'.$csv_sep;//PORCENTDSCTO
		$csv.=$email.$csv_sep;//EMAIL
		$csv.=''.$csv_sep;//TIPOSERVICIO (1: Boletas de servicios periódico ó Facturas de servicios periódicos domiciliarios; 2:Boletas de servicios periódicos domiciliarios ó Facturas de otros servicios periódicos; 3:Boletas de venta y servicios ó Factura de servicios)
		$csv.=''.$csv_sep;//PERIODODESDE
		$csv.=''.$csv_sep;//PERIODOHASTA
		$csv.=''.$csv_sep;//FECHAVENCIMIENTO
		$csv.='1'.$csv_sep;//CODSUCURSAL
		$csv.=$datos_venta[0]['VENDEDOR'].$csv_sep;//VENDEDOR
		$csv.=''.$csv_sep;//CODRECEPTOR
		$csv.=''.$csv_sep;/*CODITEM*/
		$csv.=''.$csv_sep;//UNIDADMEDIDA(HR,KG,MR,PM,PP,QTAL,TBDM,TBDU,TON,UNID)
		$csv.=''.$csv_sep;//PORCENTDSCTO2
		$csv.=''.$csv_sep;//PORCENTDSCTO3
		$csv.=''.$csv_sep;//CODIGOIMP
		$csv.=''.$csv_sep;//MONTOIMP
		$csv.=''.$csv_sep;//INDICADORTRASLADO(1:Operacion constituye venta,2:Ventas por efectuar,3:Consignaciones,4:Entrega gratuita,5:Traslados internos,6:Otros traslados no venta,7:Guia de devolucion)
		$csv.=$forma_pago.$csv_sep;//FORMAPAGO(1:Contado, 2:Credito, 3:Sin costo)
		$csv.=$medio_pago.$csv_sep;//MEDIOPAGO(CH:Cheque,CF:Cheque a fecha,LT:letra,EF:Efectivo,PE:Pago a cta.cte,TC:Tarjeta Credito,OT:Otro)
		$csv.=''.$csv_sep;//TERMINOSPAGOSDIAS
		$csv.=''.$csv_sep;//TERMINOSPAGOCODIGO
		$csv.=''.$csv_sep;//COMUNADESTINO
		$csv.=''.$csv_sep;//RUTSOLICITANTEFACTURA
		$csv.=''.$csv_sep;//PRODUCTOCAMBIOSUJETO
		$csv.=''.$csv_sep;//CANTIDADMONTOCAMBIOSUJETO
		$csv.=''.$csv_sep;//TIPOGLOBALAFECTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
		$csv.=''.$csv_sep;//VALORGLOBALAFECTO	
		$csv.=''.$csv_sep;//TIPOGLOBALEXENTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
		$csv.=''.$csv_end;//VALORGLOBALEXENTO

		
		$csv=trim($csv);
		  
		$csv_file 	= 	"notas_csv/nota_".$folio.".csv";
		//Generamos el csv de todos los datos  
		if (!$handle = fopen($csv_file, "w")) {  
		    return "Cannot open file";  
		    //exit;  
		}  
		if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
		    return "Cannot write to file";  
		    //exit;  
		}  
		fclose($handle);

		//return "Archivo Creado";

		//
		$csv_ref = "";

		$csv_ref.="TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)".$csv_sep;
		$csv_ref.="FOLIO".$csv_sep;
		$csv_ref.="SECUENCIA".$csv_sep;
		$csv_ref.="TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)".$csv_sep;
		$csv_ref.="FOLIO DOCUMENTO REFERENCIADO".$csv_sep;
		$csv_ref.="FECHA DOCUMENTO REFERENCIADO".$csv_sep;
		$csv_ref.="MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)".$csv_sep;
		$csv_ref.="GLOSA REFERENCIA".$csv_sep.$csv_end;

		$referencias 	= false;
		$contador_ref	= 0;

		$contador_ref++;
		$referencias = true;

		$identificador_ref = "33";

		if($datos_venta[0]['TDOCTO']=='BOLETA')
		{
			$identificador_ref = "39";
		}

		$fecha_doc=explode("-",$datos_venta[0]['FECHA']);
        $fecha_formateada_ref= $fecha_doc['2']."/".$fecha_doc['1']."/".$fecha_doc['0'];

        $anula_documento = false;

		$csv_ref.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)			
		$csv_ref.=$folio.$csv_sep;//FOLIO
		$csv_ref.=$contador_ref.$csv_sep;//SECUENCIA
		$csv_ref.=$identificador_ref.$csv_sep;//TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)
		$csv_ref.=$datos_venta[0]['FOLIO'].$csv_sep;//FOLIO DOCUMENTO REFERENCIADO
		$csv_ref.=$fecha_formateada_ref.$csv_sep;//FECHA DOCUMENTO REFERENCIADO
		if($anula_documento)
		{
			$csv_ref.="1".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
		}else{
			$csv_ref.="3".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
		}
		//$csv_ref.="".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
		$csv_ref.="Descuento $porcentaje %".$csv_end;//GLOSA REFERENCIA


	
		if($referencias == true)
		{
			$csv_ref=trim($csv_ref);
		  
			$csv_file_ref 	= 	"ref_facturas_csv/nota_".$folio.".csv";
			//Generamos el csv de todos los datos  
			if (!$handle2 = fopen($csv_file_ref, "w")) {  
			    return "Cannot open file";  
			    exit;  
			}  
			if (fwrite($handle2, utf8_decode($csv_ref)) === FALSE) {  
			    return "Cannot write to file";  
			    exit;  
			}  
			fclose($handle2);
		}

		return "Archivo Creado";


	}

	function csv_nota_error($datos_cliente,$datos_venta,$folio,$rut,$fpago,$valor,$error)
	{
		$identificador = "61";

$csv_end 	= 	"
";  
		$csv_sep 	= 	";";  
		
		$csv = retorna_cabezera($csv_sep,$csv_end);

	    $contador		=	1;

    
		//
		$forma_pago="1";

		if($fpago == "CREDITO")
		{
			$forma_pago ="2";
		}

		$medio_pago = obtener_medio_pago($datos_venta[0]["PAGO"]);

        //$folio 				=	$row_v['FOLIO'];
        $rutsinpunto 		= 	str_replace (".", "", $rut);
        $rutsinpunto		=	ltrim($rutsinpunto,"0");
        $nombreclie=utf8_encode($datos_cliente[0]['NOMBRE']);
        $giro=utf8_encode($datos_cliente[0]['GIRO']);
        $comuna=utf8_encode($datos_cliente[0]['COMUNA']);
        $direccion=utf8_encode($datos_cliente[0]['DIRECCION']);
        $email=$datos_cliente[0]['EMAIL'];

        $hoy = date("Y-m-d");
        
        $lafecha=explode("-",$hoy);
        $fecha_formateada= $lafecha['2']."/".$lafecha['1']."/".$lafecha['0'];

        
        //sacar neto
        $valor_unitario 	= $valor;

        $valor_neto 		= round($valor_unitario/1.19);

		$csv.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura exenta electrónica, 46: Factura de compra electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 39: Boleta electrónica; 41: Boleta exenta electrónica )
		$csv.=$folio.$csv_sep;//FOLIO
		$csv.=$contador.$csv_sep;//SECUENCIA
		$csv.=$fecha_formateada.$csv_sep;//FECHA
		$csv.=$rutsinpunto.$csv_sep;//RUT
		$csv.=$nombreclie.$csv_sep;//RAZONSOCIAL
		$csv.=$giro.$csv_sep;//GIRO
		$csv.=$comuna.$csv_sep;//COMUNA
		$csv.=$direccion.$csv_sep;//DIRECCION
		$csv.='SI'.$csv_sep;//AFECTO
		$csv.=$error.$csv_sep;//PRODUCTO
		$csv.=''.$csv_sep;//DESCRIPCION
		$csv.="0".$csv_sep;//CANTIDAD	
		$csv.=$valor_neto.$csv_sep;//PRECIO
		//$csv.=$row['DESCUENTO'].$csv_sep;//PORCENTDSCTO
		$csv.='0'.$csv_sep;//PORCENTDSCTO
		$csv.=$email.$csv_sep;//EMAIL
		$csv.=''.$csv_sep;//TIPOSERVICIO (1: Boletas de servicios periódico ó Facturas de servicios periódicos domiciliarios; 2:Boletas de servicios periódicos domiciliarios ó Facturas de otros servicios periódicos; 3:Boletas de venta y servicios ó Factura de servicios)
		$csv.=''.$csv_sep;//PERIODODESDE
		$csv.=''.$csv_sep;//PERIODOHASTA
		$csv.=''.$csv_sep;//FECHAVENCIMIENTO
		$csv.='1'.$csv_sep;//CODSUCURSAL
		$csv.=$datos_venta[0]['VENDEDOR'].$csv_sep;//VENDEDOR
		$csv.=''.$csv_sep;//CODRECEPTOR
		$csv.=''.$csv_sep;/*CODITEM*/
		$csv.=''.$csv_sep;//UNIDADMEDIDA(HR,KG,MR,PM,PP,QTAL,TBDM,TBDU,TON,UNID)
		$csv.=''.$csv_sep;//PORCENTDSCTO2
		$csv.=''.$csv_sep;//PORCENTDSCTO3
		$csv.=''.$csv_sep;//CODIGOIMP
		$csv.=''.$csv_sep;//MONTOIMP
		$csv.=''.$csv_sep;//INDICADORTRASLADO(1:Operacion constituye venta,2:Ventas por efectuar,3:Consignaciones,4:Entrega gratuita,5:Traslados internos,6:Otros traslados no venta,7:Guia de devolucion)
		$csv.=$forma_pago.$csv_sep;//FORMAPAGO(1:Contado, 2:Credito, 3:Sin costo)
		$csv.=$medio_pago.$csv_sep;//MEDIOPAGO(CH:Cheque,CF:Cheque a fecha,LT:letra,EF:Efectivo,PE:Pago a cta.cte,TC:Tarjeta Credito,OT:Otro)
		$csv.=''.$csv_sep;//TERMINOSPAGOSDIAS
		$csv.=''.$csv_sep;//TERMINOSPAGOCODIGO
		$csv.=''.$csv_sep;//COMUNADESTINO
		$csv.=''.$csv_sep;//RUTSOLICITANTEFACTURA
		$csv.=''.$csv_sep;//PRODUCTOCAMBIOSUJETO
		$csv.=''.$csv_sep;//CANTIDADMONTOCAMBIOSUJETO
		$csv.=''.$csv_sep;//TIPOGLOBALAFECTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
		$csv.=''.$csv_sep;//VALORGLOBALAFECTO	
		$csv.=''.$csv_sep;//TIPOGLOBALEXENTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
		$csv.=''.$csv_end;//VALORGLOBALEXENTO

		
		$csv=trim($csv);
		  
		$csv_file 	= 	"notas_csv/nota_".$folio.".csv";
		//Generamos el csv de todos los datos  
		if (!$handle = fopen($csv_file, "w")) {  
		    return "Cannot open file";  
		    //exit;  
		}  
		if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
		    return "Cannot write to file";  
		    //exit;  
		}  
		fclose($handle);

		//return "Archivo Creado";

		//
		$csv_ref = "";

		$csv_ref.="TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)".$csv_sep;
		$csv_ref.="FOLIO".$csv_sep;
		$csv_ref.="SECUENCIA".$csv_sep;
		$csv_ref.="TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)".$csv_sep;
		$csv_ref.="FOLIO DOCUMENTO REFERENCIADO".$csv_sep;
		$csv_ref.="FECHA DOCUMENTO REFERENCIADO".$csv_sep;
		$csv_ref.="MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)".$csv_sep;
		$csv_ref.="GLOSA REFERENCIA".$csv_sep.$csv_end;

		$referencias 	= false;
		$contador_ref	= 0;

		$contador_ref++;
		$referencias = true;

		$identificador_ref = "33";

		if($datos_venta[0]['TDOCTO']=='BOLETA')
		{
			$identificador_ref = "39";
		}

		$fecha_doc=explode("-",$datos_venta[0]['FECHA']);
        $fecha_formateada_ref= $fecha_doc['2']."/".$fecha_doc['1']."/".$fecha_doc['0'];

        $anula_documento = false;

		$csv_ref.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)			
		$csv_ref.=$folio.$csv_sep;//FOLIO
		$csv_ref.=$contador_ref.$csv_sep;//SECUENCIA
		$csv_ref.=$identificador_ref.$csv_sep;//TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)
		$csv_ref.=$datos_venta[0]['FOLIO'].$csv_sep;//FOLIO DOCUMENTO REFERENCIADO
		$csv_ref.=$fecha_formateada_ref.$csv_sep;//FECHA DOCUMENTO REFERENCIADO
		
		$csv_ref.="2".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
		
		$csv_ref.="Correcion: $error".$csv_end;//GLOSA REFERENCIA


	
		if($referencias == true)
		{
			$csv_ref=trim($csv_ref);
		  
			$csv_file_ref 	= 	"ref_facturas_csv/nota_".$folio.".csv";
			//Generamos el csv de todos los datos  
			if (!$handle2 = fopen($csv_file_ref, "w")) {  
			    return "Cannot open file";  
			    exit;  
			}  
			if (fwrite($handle2, utf8_decode($csv_ref)) === FALSE) {  
			    return "Cannot write to file";  
			    exit;  
			}  
			fclose($handle2);
		}

		return "Archivo Creado";


	}	

function csv_guia($detalle_solicitud,$datos_cliente,$datos_venta,$folio,$medio_pago)
	{
		$identificador = "52";

$csv_end 	= 	"
";  
		$csv_sep 	= 	";";  
		
		$csv = retorna_cabezera($csv_sep,$csv_end);

	    $contador		=	1;

	    
		//
		$forma_pago="1";

		if($datos_venta[0]["PAGO"] == "CREDITO")
		{
			$forma_pago ="2";
		}

		/*************************************/

		$medio_pago = trim($medio_pago,"-");

		$arreglo_medio_pago = explode("-", $medio_pago);

		if(count($arreglo_medio_pago)>1){
			$medio_pago = "OT";
		}else{
			$medio_pago = $arreglo_medio_pago[0];
		}

        $rutsinpunto 		= 	str_replace (".", "", $datos_venta[0]['RUT']);
        $rutsinpunto		=	ltrim($rutsinpunto,"0");
        $nombreclie=utf8_encode($datos_cliente[0]['NOMBRE']);
        $giro=utf8_encode($datos_cliente[0]['GIRO']);
        $comuna=utf8_encode($datos_cliente[0]['COMUNA']);
        $direccion=utf8_encode($datos_cliente[0]['DIRECCION']);
        $email=$datos_cliente[0]['EMAIL'];

        $hoy = date("Y-m-d");
        
        $lafecha=explode("-",$hoy);
        $fecha_formateada= $lafecha['2']."/".$lafecha['1']."/".$lafecha['0'];

        foreach ($detalle_solicitud as $clave => $valor) {
	        //sacar neto
	        $valor_unitario 	= $valor['SUBTOTAL']/$valor['CANT'];

	        $valor_neto 		= round($valor_unitario/1.19);

			$csv.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura exenta electrónica, 46: Factura de compra electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 39: Boleta electrónica; 41: Boleta exenta electrónica )
			$csv.=$folio.$csv_sep;//FOLIO
			$csv.=$contador.$csv_sep;//SECUENCIA
			$csv.=$fecha_formateada.$csv_sep;//FECHA
			$csv.=$rutsinpunto.$csv_sep;//RUT
			$csv.=$nombreclie.$csv_sep;//RAZONSOCIAL
			$csv.=$giro.$csv_sep;//GIRO
			$csv.=$comuna.$csv_sep;//COMUNA
			$csv.=$direccion.$csv_sep;//DIRECCION
			$csv.='SI'.$csv_sep;//AFECTO
			$csv.=utf8_encode($valor['DESCRIPCION']).$csv_sep;//PRODUCTO
			$csv.=''.$csv_sep;//DESCRIPCION
			$csv.=$valor['CANT'].$csv_sep;//CANTIDAD	
			$csv.=$valor_neto.$csv_sep;//PRECIO
			//$csv.=$row['DESCUENTO'].$csv_sep;//PORCENTDSCTO
			$csv.='0'.$csv_sep;//PORCENTDSCTO
			$csv.=$email.$csv_sep;//EMAIL
			$csv.=''.$csv_sep;//TIPOSERVICIO (1: Boletas de servicios periódico ó Facturas de servicios periódicos domiciliarios; 2:Boletas de servicios periódicos domiciliarios ó Facturas de otros servicios periódicos; 3:Boletas de venta y servicios ó Factura de servicios)
			$csv.=''.$csv_sep;//PERIODODESDE
			$csv.=''.$csv_sep;//PERIODOHASTA
			$csv.=''.$csv_sep;//FECHAVENCIMIENTO
			$csv.='1'.$csv_sep;//CODSUCURSAL
			$csv.=$datos_venta[0]['VENDEDOR'].$csv_sep;//VENDEDOR
			$csv.=''.$csv_sep;//CODRECEPTOR
			$csv.=$valor['CODIGO'].$csv_sep;/*CODITEM*/
			$csv.=''.$csv_sep;//UNIDADMEDIDA(HR,KG,MR,PM,PP,QTAL,TBDM,TBDU,TON,UNID)
			$csv.=''.$csv_sep;//PORCENTDSCTO2
			$csv.=''.$csv_sep;//PORCENTDSCTO3
			$csv.=''.$csv_sep;//CODIGOIMP
			$csv.=''.$csv_sep;//MONTOIMP
			$csv.='1'.$csv_sep;//INDICADORTRASLADO(1:Operacion constituye venta,2:Ventas por efectuar,3:Consignaciones,4:Entrega gratuita,5:Traslados internos,6:Otros traslados no venta,7:Guia de devolucion)
			$csv.=$forma_pago.$csv_sep;//FORMAPAGO(1:Contado, 2:Credito, 3:Sin costo)
			$csv.=''.$csv_sep;//MEDIOPAGO(CH:Cheque,CF:Cheque a fecha,LT:letra,EF:Efectivo,PE:Pago a cta.cte,TC:Tarjeta Credito,OT:Otro)
			$csv.=''.$csv_sep;//TERMINOSPAGOSDIAS
			$csv.=''.$csv_sep;//TERMINOSPAGOCODIGO
			$csv.=$comuna.$csv_sep;//COMUNADESTINO
			$csv.=''.$csv_sep;//RUTSOLICITANTEFACTURA
			$csv.=''.$csv_sep;//PRODUCTOCAMBIOSUJETO
			$csv.=''.$csv_sep;//CANTIDADMONTOCAMBIOSUJETO
			$csv.=''.$csv_sep;//TIPOGLOBALAFECTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
			$csv.=''.$csv_sep;//VALORGLOBALAFECTO	
			$csv.=''.$csv_sep;//TIPOGLOBALEXENTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
			$csv.=''.$csv_end;//VALORGLOBALEXENTO

			$contador++;

		}
		$csv=trim($csv);
		  
		$csv_file 	= 	"guias_csv/guia_".$folio.".csv";
		//Generamos el csv de todos los datos  
		if (!$handle = fopen($csv_file, "w")) {  
		    return "Cannot open file";  
		    //exit;  
		}  
		if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
		    return "Cannot write to file";  
		    //exit;  
		}  
		fclose($handle);

		//return "Archivo Creado";

		return "Archivo Creado";

		
	}

function csv_guia_traslado($detalle_solicitud,$datos_cliente,$datos_venta,$folio,$comuna_despacho,$articulo)
	{
		$identificador = "52";

$csv_end 	= 	"
";  
		$csv_sep 	= 	";";  
		
		$csv = retorna_cabezera($csv_sep,$csv_end);

	    $contador		=	1;

	    
		//
		//$forma_pago="1";

		/*************************************/

		/*$medio_pago = trim($medio_pago,"-");

		$arreglo_medio_pago = explode("-", $medio_pago);

		if(count($arreglo_medio_pago)>1){
			$medio_pago = "OT";
		}else{
			$medio_pago = $arreglo_medio_pago[0];
		}*/

		$tipo_traslado = "";

		switch ($datos_venta[0]["tipo"]) {
			case 'Traslado Otro Local':
				$tipo_traslado = "5";
				# code...
				break;
			case 'Traslado Especial':
			case 'Traslado Pendiente':
			case 'Devolucion Proveedor':
				$tipo_traslado = "6";
				# code...
				break;
			
			default:
				# code...
				break;
		}

        $rutsinpunto 		= 	str_replace (".", "", $datos_venta[0]['rut']);
        $rutsinpunto		=	ltrim($rutsinpunto,"0");
        $nombreclie=utf8_encode($datos_cliente[0]['NOMBRE']);
        $giro=utf8_encode($datos_cliente[0]['GIRO']);
        $comuna=utf8_encode($datos_cliente[0]['COMUNA']);
        $direccion=utf8_encode($datos_cliente[0]['DIRECCION']);
        $email=$datos_cliente[0]['EMAIL'];

        $hoy = date("Y-m-d");
        
        $lafecha=explode("-",$hoy);
        $fecha_formateada= $lafecha['2']."/".$lafecha['1']."/".$lafecha['0'];

        foreach ($detalle_solicitud as $clave => $valor) {
        	$articulo->nuevo_codigo($valor['codigo']);
	        //sacar neto
	        $valor_unitario 	= $articulo->retorna("ULT_PREC_VENTA");

	        $valor_neto 		= round($valor_unitario/1.19);

			$csv.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura exenta electrónica, 46: Factura de compra electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 39: Boleta electrónica; 41: Boleta exenta electrónica )
			$csv.=/*$folio*/'1'.$csv_sep;//FOLIO
			$csv.=$contador.$csv_sep;//SECUENCIA
			$csv.=$fecha_formateada.$csv_sep;//FECHA
			$csv.=$rutsinpunto.$csv_sep;//RUT
			$csv.=$nombreclie.$csv_sep;//RAZONSOCIAL
			$csv.=$giro.$csv_sep;//GIRO
			$csv.=$comuna.$csv_sep;//COMUNA
			$csv.=$direccion.$csv_sep;//DIRECCION
			$csv.='SI'.$csv_sep;//AFECTO
			$csv.=utf8_encode($articulo->retorna_sin_formato("descripcion")).$csv_sep;//PRODUCTO
			$csv.=''.$csv_sep;//DESCRIPCION
			$csv.=$valor['cantidad'].$csv_sep;//CANTIDAD	
			$csv.=$valor_neto.$csv_sep;//PRECIO
			$csv.='0'.$csv_sep;//PORCENTDSCTO
			$csv.=$email.$csv_sep;//EMAIL
			$csv.=''.$csv_sep;//TIPOSERVICIO (1: Boletas de servicios periódico ó Facturas de servicios periódicos domiciliarios; 2:Boletas de servicios periódicos domiciliarios ó Facturas de otros servicios periódicos; 3:Boletas de venta y servicios ó Factura de servicios)
			$csv.=''.$csv_sep;//PERIODODESDE
			$csv.=''.$csv_sep;//PERIODOHASTA
			$csv.=''.$csv_sep;//FECHAVENCIMIENTO
			$csv.='1'.$csv_sep;//CODSUCURSAL
			$csv.=$datos_venta[0]['user'].$csv_sep;//VENDEDOR
			$csv.=''.$csv_sep;//CODRECEPTOR
			$csv.=$valor['codigo'].$csv_sep;/*CODITEM*/
			$csv.=''.$csv_sep;//UNIDADMEDIDA(HR,KG,MR,PM,PP,QTAL,TBDM,TBDU,TON,UNID)
			$csv.=''.$csv_sep;//PORCENTDSCTO2
			$csv.=''.$csv_sep;//PORCENTDSCTO3
			$csv.=''.$csv_sep;//CODIGOIMP
			$csv.=''.$csv_sep;//MONTOIMP
			$csv.=$tipo_traslado.$csv_sep;//INDICADORTRASLADO(1:Operacion constituye venta,2:Ventas por efectuar,3:Consignaciones,4:Entrega gratuita,5:Traslados internos,6:Otros traslados no venta,7:Guia de devolucion)
			$csv.=''.$csv_sep;//FORMAPAGO(1:Contado, 2:Credito, 3:Sin costo)
			$csv.=''.$csv_sep;//MEDIOPAGO(CH:Cheque,CF:Cheque a fecha,LT:letra,EF:Efectivo,PE:Pago a cta.cte,TC:Tarjeta Credito,OT:Otro)
			$csv.=''.$csv_sep;//TERMINOSPAGOSDIAS
			$csv.=''.$csv_sep;//TERMINOSPAGOCODIGO
			$csv.=$comuna_despacho.$csv_sep;//COMUNADESTINO
			$csv.=''.$csv_sep;//RUTSOLICITANTEFACTURA
			$csv.=''.$csv_sep;//PRODUCTOCAMBIOSUJETO
			$csv.=''.$csv_sep;//CANTIDADMONTOCAMBIOSUJETO
			$csv.=''.$csv_sep;//TIPOGLOBALAFECTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
			$csv.=''.$csv_sep;//VALORGLOBALAFECTO	
			$csv.=''.$csv_sep;//TIPOGLOBALEXENTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
			$csv.=''.$csv_end;//VALORGLOBALEXENTO

			$contador++;

		}
		$csv=trim($csv);
		  
		//$csv_file 	= 	"guias_csv/guia_".$folio.".csv";
		$csv_file 	= 	"ventas_csv/guia_".$folio.".csv";
		//Generamos el csv de todos los datos  
		if (!$handle = fopen($csv_file, "w")) {  
		    return "Cannot open file";  
		    //exit;  
		}  
		if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
		    return "Cannot write to file";  
		    //exit;  
		}  
		fclose($handle);

		//ver si hay documento a referenciar

		if(!is_null($datos_venta[0]['documento_ref']))
		{
			$tdoc_ref = $datos_venta[0]['documento_ref'];
			$ndoc_ref = $datos_venta[0]['n_documento_ref'];
			$busca_ref = new Consulta("SELECT * from venta where Tipo='Electronica' and TDOCTO='$tdoc_ref' and FOLIO='$ndoc_ref'");

			if($busca_ref->filas_resultado()>0)
			{				
				$datos_ref = $busca_ref->resultado_arreglo();
				$csv_ref = "";

				$csv_ref.="TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)".$csv_sep;
				$csv_ref.="FOLIO".$csv_sep;
				$csv_ref.="SECUENCIA".$csv_sep;
				$csv_ref.="TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)".$csv_sep;
				$csv_ref.="FOLIO DOCUMENTO REFERENCIADO".$csv_sep;
				$csv_ref.="FECHA DOCUMENTO REFERENCIADO".$csv_sep;
				$csv_ref.="MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)".$csv_sep;
				$csv_ref.="GLOSA REFERENCIA".$csv_sep.$csv_end;
				
				$contador_ref	= 0;

				$contador_ref++;
				$referencias = true;

				$identificador_ref = "33";

				if($datos_ref[0]['TDOCTO']=='BOLETA')
				{
					$identificador_ref = "39";
				}

				$fecha_doc=explode("-",$datos_ref[0]['FECHA']);
		        $fecha_formateada_ref= $fecha_doc['2']."/".$fecha_doc['1']."/".$fecha_doc['0'];

				$csv_ref.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)			
				$csv_ref.=/*$folio*/'1'.$csv_sep;//FOLIO
				$csv_ref.=$contador_ref.$csv_sep;//SECUENCIA
				$csv_ref.=$identificador_ref.$csv_sep;//TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)
				$csv_ref.=$datos_ref[0]['FOLIO'].$csv_sep;//FOLIO DOCUMENTO REFERENCIADO
				$csv_ref.=$fecha_formateada_ref.$csv_sep;//FECHA DOCUMENTO REFERENCIADO
				$csv_ref.="".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
				
				$csv_ref.="Traslado Pendiente de Mercaderia".$csv_end;//GLOSA REFERENCIA

				if($referencias == true)
				{
					$csv_ref=trim($csv_ref);
				  
					$csv_file_ref 	= 	"ref_facturas_csv/guia_".$folio.".csv";
					//Generamos el csv de todos los datos  
					if (!$handle2 = fopen($csv_file_ref, "w")) {  
					    return "Cannot open file";  
					    //exit;  
					}  
					if (fwrite($handle2, utf8_decode($csv_ref)) === FALSE) {  
					    return "Cannot write to file";  
					    //exit;  
					}  
					fclose($handle2);
				}
			}else{
				return "Error en referenciar Documento";
			}
		}

		return "Archivo Creado";

}

function csv_venta($detalle_solicitud,$datos_cliente,$datos_venta,$folio,$medio_pago)
	{
		$identificador = "33";
		$constituye_venta = "";
		$campos_detalle = array("CODIGO"=>"COD_ART1","CANTIDAD"=>"CANTIDAD");

		if($datos_venta[0]['TDOCTO'] == "BOLETA")
		{
			$identificador = "39";
		}elseif ($datos_venta[0]['TDOCTO'] == "GUIA DESPACHO") {
			$identificador = "52";
			$constituye_venta = "1";
			$campos_detalle["CODIGO"]="CODIGO";
			$campos_detalle["CANTIDAD"]="CANT";
			$medio_pago = "";
		}

$csv_end 	= 	"
";  
		$csv_sep 	= 	";";  
		
		$csv = retorna_cabezera($csv_sep,$csv_end);

	    $contador		=	1;

	    
		//
		$forma_pago="1";

		if($datos_venta[0]["PAGO"] == "CREDITO")
		{
			$forma_pago ="2";
		}

		/*************************************/

		$rutsinpunto 		= 	str_replace (".", "", $datos_venta[0]['RUT']);
        $rutsinpunto		=	ltrim($rutsinpunto,"0");
        $nombreclie=utf8_encode($datos_cliente[0]['NOMBRE']);
        $giro=utf8_encode($datos_cliente[0]['GIRO']);
        $comuna=utf8_encode($datos_cliente[0]['COMUNA']);
        $direccion=utf8_encode($datos_cliente[0]['DIRECCION']);
        $email=$datos_cliente[0]['EMAIL'];

        $hoy = date("Y-m-d");
        
        $lafecha=explode("-",$hoy);
        $fecha_formateada= $lafecha['2']."/".$lafecha['1']."/".$lafecha['0'];

        foreach ($detalle_solicitud as $clave => $valor) {
	        //sacar neto
	        $valor_unitario 	= $valor['SUBTOTAL']/$valor[$campos_detalle['CANTIDAD']];

	        $valor_neto 		= round($valor_unitario/1.19);

	        $valor_unitario 	= round($valor_unitario);

			$csv.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura exenta electrónica, 46: Factura de compra electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 39: Boleta electrónica; 41: Boleta exenta electrónica )
			$csv.="1".$csv_sep;//FOLIO
			$csv.=$contador.$csv_sep;//SECUENCIA
			$csv.=$fecha_formateada.$csv_sep;//FECHA
			$csv.=$rutsinpunto.$csv_sep;//RUT
			$csv.=$nombreclie.$csv_sep;//RAZONSOCIAL
			$csv.=$giro.$csv_sep;//GIRO
			$csv.=$comuna.$csv_sep;//COMUNA
			$csv.=$direccion.$csv_sep;//DIRECCION
			$csv.='SI'.$csv_sep;//AFECTO
			$csv.=utf8_encode($valor['DESCRIPCION']).$csv_sep;//PRODUCTO
			$csv.=''.$csv_sep;//DESCRIPCION
			$csv.=$valor[$campos_detalle["CANTIDAD"]].$csv_sep;//CANTIDAD
			if($identificador=="39")
			{
				$csv.=$valor_unitario.$csv_sep;//PRECIO
			}else{
				$csv.=$valor_neto.$csv_sep;//PRECIO
			}
			//$csv.=$row['DESCUENTO'].$csv_sep;//PORCENTDSCTO
			$csv.='0'.$csv_sep;//PORCENTDSCTO
			$csv.=$email.$csv_sep;//EMAIL
			if($identificador=="39")
			{
				$csv.='3'.$csv_sep;//TIPOSERVICIO (1: Boletas de servicios periódico ó Facturas de servicios periódicos domiciliarios; 2:Boletas de servicios periódicos domiciliarios ó Facturas de otros servicios periódicos; 3:Boletas de venta y servicios ó Factura de servicios)
			}else{
				$csv.=''.$csv_sep;//TIPOSERVICIO (1: Boletas de servicios periódico ó Facturas de servicios periódicos domiciliarios; 2:Boletas de servicios periódicos domiciliarios ó Facturas de otros servicios periódicos; 3:Boletas de venta y servicios ó Factura de servicios)
			}
			$csv.=''.$csv_sep;//PERIODODESDE
			$csv.=''.$csv_sep;//PERIODOHASTA
			$csv.=''.$csv_sep;//FECHAVENCIMIENTO
			$csv.='1'.$csv_sep;//CODSUCURSAL
			if($identificador == "39")
			{
				$csv.=''.$csv_sep;//VENDEDOR
			}else{
				$csv.=$datos_venta[0]['VENDEDOR'].$csv_sep;//VENDEDOR
			}
			$csv.=''.$csv_sep;//CODRECEPTOR
			$csv.=$valor[$campos_detalle['CODIGO']].$csv_sep;/*CODITEM*/
			$csv.=''.$csv_sep;//UNIDADMEDIDA(HR,KG,MR,PM,PP,QTAL,TBDM,TBDU,TON,UNID)
			$csv.=''.$csv_sep;//PORCENTDSCTO2
			$csv.=''.$csv_sep;//PORCENTDSCTO3
			$csv.=''.$csv_sep;//CODIGOIMP
			$csv.=''.$csv_sep;//MONTOIMP
			$csv.=$constituye_venta.$csv_sep;//INDICADORTRASLADO(1:Operacion constituye venta,2:Ventas por efectuar,3:Consignaciones,4:Entrega gratuita,5:Traslados internos,6:Otros traslados no venta,7:Guia de devolucion)
			if($identificador=="39")
			{
				$csv.=''.$csv_sep;//FORMAPAGO(1:Contado, 2:Credito, 3:Sin costo)
				$csv.=''.$csv_sep;//MEDIOPAGO(CH:Cheque,CF:Cheque a fecha,LT:letra,EF:Efectivo,PE:Pago a cta.cte,TC:Tarjeta Credito,OT:Otro)	
			}else{
				$csv.=$forma_pago.$csv_sep;//FORMAPAGO(1:Contado, 2:Credito, 3:Sin costo)
				$csv.=$medio_pago.$csv_sep;//MEDIOPAGO(CH:Cheque,CF:Cheque a fecha,LT:letra,EF:Efectivo,PE:Pago a cta.cte,TC:Tarjeta Credito,OT:Otro)
			}
			
			$csv.=''.$csv_sep;//TERMINOSPAGOSDIAS
			$csv.=''.$csv_sep;//TERMINOSPAGOCODIGO
			if($identificador=="39")
			{
				//
				$csv.=''.$csv_sep;//COMUNADESTINO
			}else{
				$csv.=$comuna.$csv_sep;//COMUNADESTINO
			}

			$csv.=''.$csv_sep;//RUTSOLICITANTEFACTURA
			$csv.=''.$csv_sep;//PRODUCTOCAMBIOSUJETO
			$csv.=''.$csv_sep;//CANTIDADMONTOCAMBIOSUJETO
			$csv.=''.$csv_sep;//TIPOGLOBALAFECTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
			$csv.=''.$csv_sep;//VALORGLOBALAFECTO	
			$csv.=''.$csv_sep;//TIPOGLOBALEXENTO (1:DSCTO%, 2:DSCTO$, 3:RCGO%, 4:RCGO$)
			$csv.=''.$csv_end;//VALORGLOBALEXENTO

			$contador++;

		}
		$csv=trim($csv);
		  
		$csv_file 	= 	"ventas_csv/".$datos_venta[0]['TDOCTO']."_".$folio.".csv";
		//Generamos el csv de todos los datos  
		if (!$handle = fopen($csv_file, "w")) {  
		    return "Cannot open file";  
		    //exit;  
		}  
		if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
		    return "Cannot write to file";  
		    //exit;  
		}  
		fclose($handle);

		$csv_ref = "";

		$csv_ref.="TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)".$csv_sep;
		$csv_ref.="FOLIO".$csv_sep;
		$csv_ref.="SECUENCIA".$csv_sep;
		$csv_ref.="TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)".$csv_sep;
		$csv_ref.="FOLIO DOCUMENTO REFERENCIADO".$csv_sep;
		$csv_ref.="FECHA DOCUMENTO REFERENCIADO".$csv_sep;
		$csv_ref.="MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)".$csv_sep;
		$csv_ref.="GLOSA REFERENCIA".$csv_end;


		$orden_compra 	= $datos_venta[0]['ORDENCOMPRA'];
		$guia_asociada 	= $datos_venta[0]['GUIADESPACHO'];

		$referencias 	= false;
		$contador_ref	= 0;
		if($orden_compra!= 0 && $orden_compra != NULL && !empty($orden_compra))
		{			
			$contador_ref++;
			$referencias = true;
			$csv_ref.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)			
			$csv_ref.="1".$csv_sep;//FOLIO
			$csv_ref.=$contador_ref.$csv_sep;//SECUENCIA
			$csv_ref.="801".$csv_sep;//TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)
			$csv_ref.=$orden_compra.$csv_sep;//FOLIO DOCUMENTO REFERENCIADO
			$csv_ref.=$fecha_formateada.$csv_sep;//FECHA DOCUMENTO REFERENCIADO
			$csv_ref.="".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
			$csv_ref.="Orden de Compra".$csv_end;//GLOSA REFERENCIA

		}

		if($guia_asociada!= 0 && $guia_asociada != NULL)
		{
			$busca_guia = new Consulta("SELECT * from venta WHERE TDOCTO='GUIA DESPACHO' and FOLIO='".$guia_asociada."' and Tipo='Electronica'");

			$fecha_guia="";

			if($busca_guia->filas_resultado()>0)
			{
				$respuesta_guia = $busca_guia->resultado_arreglo();

				$data_guia_facturacion = $respuesta_guia[0];

				$fecha_guia = $data_guia_facturacion['FECHA'];

				$fecha_array = explode("-", $fecha_guia);

				$fecha_guia = $fecha_array[2]."/".$fecha_array[1]."/".$fecha_array[0];

			}
			$contador_ref++;
			$referencias = true;
			$csv_ref.=$identificador.$csv_sep;//TIPO (33: Factura electrónica, 34:Factura electrónica exenta, 56: Nota débito electrónica, 61:Nota de crédito electrónica)			
			$csv_ref.="1".$csv_sep;//FOLIO
			$csv_ref.=$contador_ref.$csv_sep;//SECUENCIA
			$csv_ref.="52".$csv_sep;//TIPO DOCUMENTO REFERENCIADO (30: Factura, 33: Factura electrónica, 34:Factura electrónica exenta, 39: Boleta Electrónica, 41: Boleta Electrónica Exenta, 45: Factura de Compra, 46: Factura de Compra Electrónica, 50: Guía de Despacho, 52: Guía de despacho electrónica, 56: Nota débito electrónica, 61:Nota de crédito electrónica, 103:Liquidación, 801: Orden de Compra, 802: Nota de Pedido, NVE: Nota de Venta, CEC: Centro de Costo)
			$csv_ref.=$guia_asociada.$csv_sep;//FOLIO DOCUMENTO REFERENCIADO
			$csv_ref.=$fecha_guia.$csv_sep;//FECHA DOCUMENTO REFERENCIADO
			$csv_ref.="".$csv_sep;//MOTIVO REFERENCIA(1: Anula documento, 2: Corrige texto, 3: Corrige monto)
			$csv_ref.="Facturacion Guia".$csv_end;//GLOSA REFERENCIA
		}

		if($referencias == true)
		{
			$csv_ref=trim($csv_ref);
		  
			$csv_file_ref 	= 	"referencias_csv/".$datos_venta[0]['TDOCTO']."_".$folio.".csv";
			//Generamos el csv de todos los datos  
			if (!$handle2 = fopen($csv_file_ref, "w")) {  
			    echo "Cannot open file";  
			    exit;  
			}  
			if (fwrite($handle2, utf8_decode($csv_ref)) === FALSE) {  
			    echo "Cannot write to file";  
			    exit;  
			}  
			fclose($handle2);
		}

		//return "Archivo Creado";

		return "Archivo Creado";
		
	}	
?>