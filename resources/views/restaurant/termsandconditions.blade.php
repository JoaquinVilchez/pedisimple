@extends('layouts.app')

@section('content')
    <div class="container container-fluid py-4">
        <h4 class="txt-semi-bold" style="text-align: center">Términos y condiciones</h4>
        <hr>

        <div class="px-4">
            <p>En el siguiente enunciado se mostrarán los términos y condiciones bajo los cuales se deben cumplir para el correcto uso de la plataforma.</p>

            <p>
                {{env('APP_NAME')}} es un servicio que ofrece a los comerciantes gastronómicosrecibir pedidos online de los distintos productos que se ofrecen en la plataforma.
                Al utilizar nuestro servicio usted aprueba que haya leído, entendido y aceptado estar sujeto a los siguientes términos y condiciones:
            </p>
        </div>

        <hr>

        <p class="txt-semi-bold">El comercio debe:</p>
        <ul>
            <li>
                Contar con un responsable comercial mayor de 18 años de edad y poseer la autoridad legal, el derecho y la libertad para participar en estos términos como un acuerdo vinculante.
            </li>
            <li>
                Contar con una dirección comercial real.
            </li>
            <li>
                Permitir servicio de delivery, take away o ambas.
            </li>
            <li>
                Tener acceso a conexión de internet.
            </li>
            <li>
                Contar con horarios de atención al cliente determinados.
            </li>
            <li>
                Contar con correo electrónico y número telefónico para la comunicación con clientes y administrativos. 
            </li>
            <li>
                Contar con una computadora o tablet (Excluyente). No se permiten comercios que utilicen las funciones de la plataforma únicamente con teléfonos celulares.
            </li>

        </ul>

        <div class="card">
            <div class="card-body">
                {{env('APP_NAME')}} se reserva el derecho de admisión de los comercios.
            </div>
        </div>

        <br>
        <hr>

        <p class="txt-semi-bold">Productos a publicar:</p>
        <ul>
            <li>
                Deben ser productos únicamente gastronómicos o alimenticios establecidos dentro de las categorías que la plataforma ofrece.
            </li>
            <li>
                Se deben ofrecer de manera unitaria. No se pueden publicar productos con precio por kilogramo, gramo o cualquier otra unidad que no se pueda definir el precio final en la plataforma.
            </li>
            <li>
                El precio publicado en la plataforma deberá estar actualizado y será el precio final del mismo a la hora de que un cliente realice un pedido.
            </li>
            <li>
                Las imágenes representativas de los productos deben ser reales así como también tener carácter ilustrativo y ser de una calidad aceptable por la plataforma.
            </li>
        </ul>

        <div class="card">
            <div class="card-body">
                Estos términos deben cumplirse de manera estricta. En caso de que no se cumplan, notificaremos al responsable para que realice los cambios correspondientes. Caso contrario, nos veremos afectados a modificar la información en caso de que sea posible o tomar medidas al respecto hasta solucionar el posible inconveniente.
            </div>
        </div>

        <br>
        <hr>


        <p class="txt-semi-bold">Compromisos:</p>
        <ul>
            <li>
                {{env('APP_NAME')}} no se hace responsable ante cualquier inconveniente con el producto o envío. Solo somos responsables del correcto funcionamiento de la plataforma.
            </li>
            <li>
                Al publicar información e imágenes dentro de la plataforma, {{env('APP_NAME')}} tiene el derecho a utilizar dicha información para la difusión y/o publicidad de la misma.
            </li>
            <li>
                El servicio y todos los materiales incluidos dentro de la plataforma, tales como software, imágenes, textos, gráficos, logotipos, fotografías, audio, video, flyers, entre otros, son propiedad de {{env('APP_NAME')}} y no se autoriza a los comerciantes el uso de dicha información sin previa autorización.
            </li>
            <li>
                Podemos, sin previo aviso, cambiar los servicios; dejar de proporcionar los servicios o cualquier característica de los servicios que ofrecemos; o crear límites para los mismos. Podemos  suspender de manera permanente o temporal el acceso a los servicios sin previo aviso ni responsabilidad por cualquier motivo, o sin ningún motivo sujeto a la no actualización de precios de los productos, falta de colocación de los horarios de atención al cliente, déficit en el servicio de respuestas a los pedidos, mala calidad de productos o caducación del pago mensual.
            </li>
            <li>
                Usted acuerda indemnizar y eximir de responsabilidad a {{env('APP_NAME')}} y/o propietarios de cualquier demanda, pérdida, responsabilidad, reclamo o gasto (incluidos los honorarios de abogados) que terceros realicen en tu contra como consecuencia de, o derivado de, o en relación con tu uso de la plataforma o cualquiera de los servicios ofrecidos en la misma.
            </li>
            <li>
                En la máxima medida permitida por la ley aplicable, en ningún caso {{env('APP_NAME')}} y/o propietarios será responsable por daños indirectos, punitivos, incidentales, especiales, consecuentes o ejemplares, incluidos, entre otros, daños por pérdida de beneficios, buena voluntad, uso, datos u otras pérdidas intangibles, que surjan de o estén relacionadas con el uso o la imposibilidad de utilizar el servicio.
            </li>
            <li>
                Nos reservamos el derecho de modificar estos términos cuando sea necesario a nuestra entera discreción. Por lo tanto, debes revisar estas páginas periódicamente. Cuando cambiemos los Términos de una manera material, te notificaremos que se han realizado cambios importantes en los términos. El uso continuado de la plataforma o nuestro servicio después de dicho cambio constituye tu aceptación de los nuevos términos.
            </li>
        </ul>

        <br>
        <hr>

        <p class="txt-semi-bold">Costo del servicio:</p>
        <div class="px-4">
            <p>
                El servicio es gratuito los primeros 30 días desde el alta y luego se generará un cargo mensual fijo que se deberá abonar para poder tener el servicio activo. Este precio fijo mensual puede variar mes a mes y en caso que eso suceda, se le notificará previamente. En caso que no se abone el mes correspondiente tendrá un mes más de respaldo para poder saldar la deuda. Si se acumulan 2 meses impagos, el servicio automáticamente se dará de baja hasta saldar dicha deuda. En caso que la deuda no se abone en los días correspondientes, {{env('APP_NAME')}} podrá libremente cobrar intereses correspondientes.
            </p>
        </div>

    </div>
@endsection