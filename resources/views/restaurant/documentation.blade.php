@extends('layouts.documentation')

@section('main')

<div class="row">
    <div class="d-none d-lg-block col-2 px-0" id="sidebar">
        <ul class="nav flex-column">
            <img src="{{asset('images/logo.png')}}" width="120px" class="ml-5 py-3">
            <a href="{{route('product.index')}}" class="m-4 btn btn-light" style="text-align: center; font-size:.8em"><i class="fas fa-arrow-left"></i> Volver a mi comercio</a>
            <li class="nav-item">
            <a class="nav-link txt-semi-bold" href="#docs-productos">
                <span>Productos</span>
            </a>
            <ul class="list-unstyled ml-4" style="font-size:.9em">
                <li class="nav-item">
                    <a href="#docs-int-crear-producto" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Crear un nuevo producto</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-editar-producto" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Editar producto</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-eliminar-producto" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Eliminar producto</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-disponibilidad-producto" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Disponibilidad de producto</span>
                        </div>
                    </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link txt-semi-bold" href="#docs-categorias">
                <span>Categorías</span>
            </a>
            <ul class="list-unstyled ml-4" style="font-size:.9em">
                <li class="nav-item">
                    <a href="#docs-int-crear-categoria" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Crear categoría</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-editar-categoria" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Editar categoría</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-eliminar-categoria" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Eliminar categoría</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-ordenar-categoria" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Ordenar categorías</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-disponibilidad-categoria" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Disponibilidad de categorías</span>
                        </div>
                    </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link txt-semi-bold" href="#docs-variantes">
                <span>Variantes</span>
            </a>
            <ul class="list-unstyled ml-4" style="font-size:.9em">
                <li class="nav-item">
                    <a href="#docs-int-como-funcionan-variantes" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>¿Cómo funcionan?</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-crear-variante" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Crear nueva variante</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-editar-variante" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Editar variante</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-eliminar-variante" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Eliminar variante</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-asignar-variante-a-producto" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Asignar variante a producto</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-disponibilidad-variante" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Disponibilidad de variantes</span>
                        </div>
                    </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link txt-semi-bold" href="#docs-productos-temporales">
                <span>Productos temporales</span>
            </a>
            <ul class="list-unstyled ml-4" style="font-size:.9em">
                <li class="nav-item">
                    <a href="#docs-int-como-funcionan-productos-temporales" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>¿Cómo funcionan?</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-crear-producto-temporal" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Crear producto temporal</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-editar-producto-temporal" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Editar producto temporal</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-detener-producto-temporal" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Detener producto temporal</span>
                        </div>
                    </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link txt-semi-bold" href="#docs-pedidos">
                <span>Pedidos</span>
            </a>
            <ul class="list-unstyled ml-4" style="font-size:.9em">
                <li class="nav-item">
                    <a href="#docs-int-como-funcionan-pedidos" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>¿Cómo funcionan?</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-pedido-nuevo" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Nuevos pedidos</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-pedido-aceptado" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Pedidos aceptados</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-pedido-cerrado" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Pedidos cerrados</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-editar-pedido" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Editar pedido</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-cancelar-pedido" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Cancelar pedido</span>
                        </div>
                    </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link txt-semi-bold" href="#docs-datos-comercio">
                <span>Datos de mi comercio</span>
            </a>
            <ul class="list-unstyled ml-4" style="font-size:.9em">
                <li class="nav-item">
                    <a href="#docs-int-editar-datos-comercio" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>¿Cómo editar los datos de mi comercio?</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-que-es-el-slug" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>¿Qué es el slug?</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#docs-int-comidas" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>Comidas</span>
                        </div>
                    </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link txt-semi-bold" href="#docs-horarios-apertura">
                <span>Horarios de apertura</span>
            </a>
            <ul class="list-unstyled ml-4" style="font-size:.9em">
                <li class="nav-item">
                    <a href="#docs-int-editar-horarios" style=" color:#7c7c7c">
                        <div class="d-flex justify-content-between">
                            <span>¿Cómo editar los horarios de apertura?</span>
                        </div>
                    </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link txt-semi-bold" href="#docs-datos-personales">
                    <span>Mis datos personales</span>
                </a>
                <ul class="list-unstyled ml-4" style="font-size:.9em">
                    <li class="nav-item">
                        <a href="#docs-int-direcciones" style=" color:#7c7c7c">
                            <div class="d-flex justify-content-between">
                                <span>Direcciones</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#docs-int-pedidos" style=" color:#7c7c7c">
                            <div class="d-flex justify-content-between">
                                <span>Pedidos</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#docs-int-datos" style=" color:#7c7c7c">
                            <div class="d-flex justify-content-between">
                                <span>Datos</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#docs-int-cambiar-contrasena" style=" color:#7c7c7c">
                            <div class="d-flex justify-content-between">
                                <span>Cambiar contraseña</span>
                            </div>
                        </a>
                    </li>
                </ul>
                </li>
        </ul>
    </div>


    <div class="col-12 col-lg-10">
            <div class="pt-3" style="background-color: white">
                <h4 class="txt-semi-bold ml-2">
                    Documentación
                </h4>
                <hr>
            </div>
            <div>
                <h5 class="txt-bold ml-2" id="docs-productos">Productos</h5>
                <ul class="list-unstyled border p-4 rounded">
                    <li class="txt-semi-bold docs-title" id="docs-int-crear-producto">Crear un nuevo producto</li><hr>
                    <div class="alert alert-primary" style="font-size: .8em" role="alert">
                        <i class="fas fa-exclamation-circle"></i> Nota: Antes de crear un producto es necesario que por lo menos exista una <a class="docs-link" href="#docs-categorias"><span class="txt-semi-bold">Categoría</span></a> para poder indicar a que categoría pertenece el producto.
                    </div>
                        <div class="container">
                            <li><i class="fas fa-angle-double-right"></i><u> Individualmente</u></li>
                            <p class="container">
                            Para agregar un nuevo producto de manera individual se debe dirigir al menú principal y seleccionar la opción de <a target="_autoblank" class="docs-link" href="{{route('product.create')}}"><span class="txt-semi-bold">Productos > Menú > Agregar</span></a>.
                                Allí, se le pedirán los datos necesarios para crear el producto como <i>nombre, precio, categoría</i>, entre otros. El producto puede contener <a class="docs-link" href="#docs-variantes">variantes</a> o puede ser <a class="docs-link" href="#docs-productos-temporales">temporal</a>, estas opciones serán explicadas detalladamente más adelante en ésta documentación.
                                Una vez completado todos los datos necesarios, presionar el botón <span class="txt-semi-bold">Guardar</span> que se encuentra arriba a la derecha, en caso que no quiera guardar los cambios, presionar en cancelar.
                            </p>
                        </div>

                        <div class="container">
                            <li><i class="fas fa-angle-double-right" id="docs-int-importar-excel"></i><u> Importar desde Excel</u></li>
                            <p class="container">
                                En caso de que se presente la necesidad de agregar o editar múltiples productos, la plataforma ofrece la posibilidad de importar una hoja de Excel. Para eso es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('product.index')}}"><span class="txt-semi-bold">Productos > Menú</span></a> y presionar el botón <span class="txt-semi-bold">Acciones</span>. 
                                Una vez allí deberá <a class="docs-link" href="{{route('product.export.excel')}}">descargar una plantilla</a> de los productos vigentes del comercio haciendo click en Exportar.
                                El formato de la plantilla descargada se debe respetar de manera estricta para su correcto funcionamiento. Las dos opciones de importación son:
                                <br><i class="fas fa-angle-right"></i><span class="txt-semi-bold"> Agregue nuevos productos y actualice los existentes:</span>
                                Esta opción permite mantener los productos existentes que no hayan sido modificados, editar los productos vigentes que si hayan sido modificados y agregar los nuevos productos establecidos. Esta opción es la más recomendable ya que el usuario se asegura de que no perderá ningun dato y además mantendrá las imágenes establecidas para los productos vigentes.
                                <br><i class="fas fa-angle-right"></i><span class="txt-semi-bold"> Reemplazar productos:</span>
                                Esta acción es destrutiva. Su función es eliminar todos los productos existentes y agregar los nuevos productos establecidos en la hoja de Excel. Esta acción elimina también las imágenes establecidas a cada producto.
                            </p>
                            <div class="container">
                                <div class="alert alert-primary" style="font-size: .8em" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> Nota: En caso que existan productos, es importante sólo reemplazar los datos o agregar nuevos productos y no eliminar ningún valor de la columna <span class="txt-semi-bold"> TOKEN</span>, éste mismo es necesario para realizar el proceso de importación.
                                </div>
                            </div>
                        </div>

                    <hr>
                    <li class="txt-semi-bold docs-title" id="docs-int-editar-producto">Editar producto</li>
                    <hr>
                    <p class="container">
                        <div class="container">
                            <li><i class="fas fa-angle-double-right"></i><u> Individualmente</u></li>
                            <div class="container">
                                Para editar de esta manera, es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('product.index')}}"><span class="txt-semi-bold">Productos > Menú</span></a>, una vez allí seleccionar el producto que se quiere editar y presionar en el ícono <i class="far fa-edit"></i>.
                                Dentro de la sección de Editar Producto, editar los datos necesarios y presionar el botón <span class="txt-semi-bold">Guardar</span> para realizar los cambios, caso contrario, presionar Cancelar.
                            </div>

                            <li><i class="fas fa-angle-double-right"></i><u> Importar desde Excel</u></li>
                            <div class="container">
                                Para editar los productos de forma masiva, una buena opción es a través de Excel. Para esto es necesario <a class="docs-link" href="{{route('product.export.excel')}}">descargar la plantilla</a> de los productos vigentes del comercio haciendo click en Exportar. 
                                Una vez descargada la plantilla, editar los datos necesarios de los productos vigentes, guardar el archivo e importarlo yendo a <a target="_autoblank" class="docs-link" href="{{route('product.index')}}"><span class="txt-semi-bold">Productos > Menú</span></a> y presionar el botón <span class="txt-semi-bold">Acciones</span> eligiendo la opción <span class="txt-semi-bold"> Agregue nuevos productos y actualice los existentes</span>.

                                <div class="alert alert-primary mt-3" style="font-size: .8em" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> Nota: En caso que existan productos, es importante sólo reemplazar los datos o agregar nuevos productos y no eliminar ningún valor de la columna <span class="txt-semi-bold"> TOKEN</span>, éste mismo es necesario para realizar el proceso de importación.
                                </div>
                            </div>
                        </div>
                    </p>
                    <hr>
                    <li class="txt-semi-bold docs-title" id="docs-int-eliminar-producto">Eliminar producto</li>
                    <hr>
                    <p class="container">
                        <div class="container">
                            <li><i class="fas fa-angle-double-right"></i><u> Individualmente</u></li>
                            <div class="container">
                                Para eliminar un producto es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('product.index')}}"><span class="txt-semi-bold">Productos > Menú</span></a>, una vez allí seleccionar el producto que se quiere eliminar y presionar en el ícono <i class="far fa-trash-alt"></i>, le aparecerá un mensaje de confirmación y en caso de estar seguro, presione aceptar.
                                Esta acción es destructiva y no se puede volver a recuperar el producto una vez eliminado.
                            </div>

                            <li><i class="fas fa-angle-double-right"></i><u> Eliminar todos</u></li>
                            <div class="container">
                                Para eliminar todos los productos, es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('product.index')}}"><span class="txt-semi-bold">Productos > Menú</span></a>, una vez allí presionar el botón <span class="txt-semi-bold">Acciones > Eliminar todos</span>, le aparecerá un mensaje de confirmación y en caso de estar seguro, presione aceptar.
                                Esta acción es destructiva y no se puede volver a recuperar los productos una vez eliminados.
                            </div>
                        </div>
                    </p>
                    <hr>
                    <li class="txt-semi-bold docs-title" id="docs-int-disponibilidad-producto">Disponibilidad de producto</li>
                    <hr>
                    <p class="container">
                        <div class="container">
                            Un producto puede estar disponible o no en un determinado momento. Esto puede verse afectado a la hora de que un cliente haga un pedido de un producto que no se encuentra disponible. Para ello la plataforma ofrece la posibilidad de retirarlo momentáneamente de la lista de productos vigentes pero sin eliminar sus datos. Esto se hace presionando el checkbox <i class="far fa-square"></i> en el listado de productos de <a target="_autoblank" class="docs-link" href="{{route('product.index')}}"><span class="txt-semi-bold">Productos > Menú</span></a>. 
                            Una vez que el producto vuelve a estar disponible, presionar nuevamente el checkbox para habilitarlo. Para poder visualizar el estado de un producto en especifico, del lado izquierdo de cada producto se ve un circulo de color verde en caso de estar disponible <small><i style="color:#28a745" class="fas fa-circle" data-toggle="tooltip" data-placement="bottom" title="Disponible"></i></small> y sino de color rojo en caso de no estar disponible <small><i style="color:#dc3545" class="fas fa-circle" data-toggle="tooltip" data-placement="bottom" title="No disponible"></i></small>
                        </div>
                    </p>
                </ul>

                <h5 class="txt-bold ml-2" id="docs-categorias">Categorías</h5>
                <ul class="list-unstyled border p-4 rounded">
                    <li class="txt-semi-bold docs-title" id="docs-int-crear-categoria">Crear una nueva categoría</li>
                    <p class="container">
                        Para crear una nueva categoría es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('category.index')}}"><span class="txt-semi-bold">Productos > Categorías > Agregar</span></a>. Una vez allí, completar los datos que se solicitan y presionar  <span class="txt-semi-bold">Guardar</span> en caso de querer aplicar los cambios.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-editar-categoria">Editar categoría</li>
                    <p class="container">
                        Para editar una categoría es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('category.index')}}"><span class="txt-semi-bold">Productos > Categorías</span></a>, seleccionar la categoría deseada y presionar el ícono <i class="far fa-edit"></i>. Una vez allí, editar los datos que se deseen y presionar  <span class="txt-semi-bold">Guardar</span> en caso de querer aplicar los cambios.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-eliminar-categoria">Eliminar categoría</li>
                    <p class="container">
                        Para eliminar una categoría es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('category.index')}}"><span class="txt-semi-bold">Productos > Categorías</span></a>, seleccionar la categoría deseada y presionar el ícono <i class="far fa-trash-alt"></i>, se le pedirá confirmar la acción y la categoría será eliminada.
                        Hay que tener en cuenta que a la hora de eliminar una categoría también se eliminarán todos los productos que pertenecen a ella. Esta acción es destructiva y no se puede revertir una vez realizada.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-ordenar-categoria">Ordenar categorías</li>
                    <p class="container">
                        El orden de las categorías a la hora de mostrarlas en el perfil del comercio son muy importantes debido a que algunas categorías son más relevantes que otras. La plataforma permite ordenar las categorías al gusto del usuario. Para realizar esta acción es necesario
                        dirigirse a <a target="_autoblank" class="docs-link" href="{{route('category.index')}}"><span class="txt-semi-bold">Productos > Categorías</span></a>, una vez allí, al pasar el mouse por la lista de las distintas categorías, se debe hacer click, mantener presionado y arrastrar hasta lograr el orden deseado de las categorías. 
                        El orden en que se muestran las categorías en esta sección es la misma que la que se muestra en el perfil del comercio. Una vez arrastrada la categoría, esta se guardará automáticamente en dicho lugar.
                    </p>
                    <hr>
                    <li class="txt-semi-bold docs-title" id="docs-int-disponibilidad-categoria">Disponibilidad de categorías</li>
                    <hr>
                    <p class="container">
                        <div class="container">
                            Una categoría puede estar disponible o no en un determinado momento. Esto puede verse afectado a la hora de que un cliente haga un pedido de un producto de una cierta categoría que no se encuentra disponible. Para ello la plataforma ofrece la posibilidad de retirar la categoría completa momentáneamente de la lista de productos y categorías vigentes pero sin eliminar sus datos. Esto se hace presionando el checkbox <i class="far fa-square"></i> en el listado de categorías de <a target="_autoblank" class="docs-link" href="{{route('category.index')}}"><span class="txt-semi-bold">Productos > Categorías</span></a>.
                            Una vez que la categoría vuelve a estar disponible, presionar nuevamente el checkbox para habilitarla. Para poder visualizar el estado de una categoría específica, del lado izquierdo de cada categoría se ve un círculo de color verde en caso de estar disponible <small><i style="color:#28a745" class="fas fa-circle" data-toggle="tooltip" data-placement="bottom" title="Disponible"></i></small> y sino de color rojo en caso de no estar disponible <small><i style="color:#dc3545" class="fas fa-circle" data-toggle="tooltip" data-placement="bottom" title="No disponible"></i></small>.
                            Cabe resaltar que una vez que una categoría se establece como no disponible, los productos que pertenecen a dicha categoría tambien lo estarán y por lo tanto no se mostrarán al público hasta que se habiliten nuevamente.
                        </div>
                    </p>
                </ul>

                <h5 class="txt-bold ml-2" id="docs-variantes">Variantes</h5>
                <ul class="list-unstyled border p-4 rounded">
                    <li class="txt-semi-bold docs-title" id="docs-int-como-funcionan-variantes">¿Cómo funcionan?</li>
                    <p class="container">
                        Las viarantes ofrencen la posibilidad de crear diferentes opciones para un mismo producto. Las mismas evitan crear productos repetidos que tienen diferentes opciones. <i>Por ejemplo, gustos de helado, gustos de pizza, entre otros.</i>
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-crear-variante">Crear nueva variante</li>
                    <p class="container">
                        Para establecer un producto con variantes, las mismas deben ser creadas con anterioridad. Para crear una variante se debe dirigir a la sección <a target="_autoblank" class="docs-link" href="{{route('variant.index')}}"><span class="txt-semi-bold">Productos > Variantes</span></a> y presionar el botón <span class="txt-semi-bold">Agregar</span>.
                        Una vez completados los datos, guardar los cambios y la variante estará creada y podrá asignarse a cualquier producto. Las mismas también pueden ser creadas de forma dinámica desde la creación de un producto.
                    </p>
                    <hr>
    
                    <li class="txt-semi-bold docs-title" id="docs-int-editar-variante">Editar variante</li>
                    <p class="container">
                        Para editar una variante se debe dirigir a la sección <a target="_autoblank" class="docs-link" href="{{route('variant.index')}}"><span class="txt-semi-bold">Productos > Variantes</span></a> buscar la variante que se desea editar y presionar en el ícono <i class="far fa-edit"></i>
                        Una vez completados los datos, guardar los cambios y la variante estará editada con la nueva información.
                    </p>
                    <hr>
    
                    <li class="txt-semi-bold docs-title" id="docs-int-eliminar-variante">Eliminar variante</li>
                    <p class="container">
                        Para eliminar una variante se debe dirigir a la sección <a target="_autoblank" class="docs-link" href="{{route('variant.index')}}"><span class="txt-semi-bold">Productos > Variantes</span></a> buscar la variante que se desea eliminar y presionar en el ícono <i class="far fa-trash-alt"></i>,
                        luego debe confirmar la acción y la variante será eliminada y desvinculada de todos los productos que haya sido asignada. Esta acción es destructiva y no se puede volver atrás una vez realizada.
                    </p>
                    <hr>
    
                    <li class="txt-semi-bold docs-title" id="docs-int-asignar-variante-a-producto">Asignar variante a producto</li>
                    <p class="container">
                        Para asignar una variante a un producto es necesario asignarselo a la hora de crear un producto, o al editar un producto ya vigente. Esto se puede hacer en la sección de creación o edición de un producto presionando la opción <span class="txt-semi-bold">Este producto tiene variantes</span>, una vez seleccionado, se desplegará
                        una
                    </p>
                    <hr>
    
                    <li class="txt-semi-bold docs-title" id="docs-int-disponibilidad-variante">Disponibilidad de variante</li>
                    <p class="container">
                        Una variante puede no estar disponible en un determinado momento. Para establecer como no disponible una variante se debe dirigir a la sección <a target="_autoblank" class="docs-link" href="{{route('variant.index')}}"><span class="txt-semi-bold">Productos > Variantes</span></a> buscar la variante que se desea establecer como no disponible y presionar el checkbox <i class="far fa-square"></i> en el listado de variantes.
                        Una vez que la variante vuelve a estar disponible, presionar nuevamente el checkbox para habilitarla. Para poder visualizar el estado de una variante específica, del lado izquierdo de cada variante se ve un círculo de color verde en caso de estar disponible <small><i style="color:#28a745" class="fas fa-circle" data-toggle="tooltip" data-placement="bottom" title="Disponible"></i></small> y sino de color rojo en caso de no estar disponible <small><i style="color:#dc3545" class="fas fa-circle" data-toggle="tooltip" data-placement="bottom" title="No disponible"></i></small>.
                        Cabe resaltar que una vez que una variante se establece como no disponible, los productos que pertenecen a dicha variante tambien lo estarán y por lo tanto no se mostrarán al público hasta que se habiliten nuevamente.
                    </p>
                </ul>
    
                <h5 class="txt-bold ml-2" id="docs-productos-temporales">Productos temporales</h5>
                <ul class="list-unstyled border p-4 rounded">
                    <li class="txt-semi-bold docs-title" id="docs-int-como-funcionan-productos-temporales">¿Cómo funcionan?</li>
                    <p class="container">
                        Los productos temporales son productos que sólo están vigentes durante un determinado período. A veces se presenta la necesidad de vender ciertos productos que están disponibles sólo para una fecha en especial y esta función es para crear este tipo de productos.
                    </p>
                    <hr>
    
                    <li class="txt-semi-bold docs-title" id="docs-int-crear-producto-temporal">Crear un producto temporal</li>
                    <p class="container">
                        Para crear un nuevo producto temporal es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('product.create')}}"><span class="txt-semi-bold">Productos > Temporales > Agregar</span></a> y crear un producto como cualquier otro. Una vez dentro de esta sección se debe tildar la opción <span class="txt-semi-bold">Este producto es temporal</span>. Una vez seleccionada la opción, la plataforma le pedirá indicar desde que fecha hasta que fecha el producto va a estar vigente.
                        Una vez completados los datos es importante tener en cuenta que la fecha de fin hace referencia a la fecha en que el producto temporal dejará de estar vigente, por lo tanto, esta fecha no estará incluida en la vigencia del mismo. Una vez creado el producto temporal, el mismo se podra ver en <a target="_autoblank" class="docs-link" href="{{route('product.temporaries')}}"><span class="txt-semi-bold">Productos > Temporales</span></a>
                    </p>
                    <hr>
    
                    <li class="txt-semi-bold docs-title"id="docs-int-editar-producto-temporal">Editar producto temporal</li>
                    <p class="container">
                        Para editar un producto temporal se debe dirigir a la sección <a target="_autoblank" class="docs-link" href="{{route('product.temporaries')}}"><span class="txt-semi-bold">Productos > Temporales</span></a> buscar el producto temporal que se desea editar y presionar en el ícono <i class="far fa-edit"></i>
                        Una vez completados los datos, guardar los cambios y el producto temporal estará editado con la nueva información.
                    </p>
                    <hr>
    
                    <li class="txt-semi-bold docs-title" id="docs-int-detener-producto-temporal">Detener producto temporal</li>
                    <p class="container">
                        Para detener la visualización de un producto temporal se debe dirigir a la sección <a target="_autoblank" class="docs-link" href="{{route('product.temporaries')}}"><span class="txt-semi-bold">Productos > Temporales</span></a> buscar el producto temporal que se desea detener  y presionar en el ícono <i class="fas fa-minus-circle"></i>, se pedirá confirmar la acción y una vez confirmado el producto temporal se detendrá y dejará de estar visible.
                    </p>
                </ul>
    
                <h5 class="txt-bold ml-2" id="docs-pedidos">Pedidos</h5>
                <ul class="list-unstyled border p-4 rounded">
                    <li class="txt-semi-bold docs-title" id="docs-int-como-funcionan-pedidos">¿Cómo funcionan?</li>
                    <p class="container">
                        Los pedidos son la principal función de la plataforma. Los mismos están habilitados únicamente en los <a class="docs-link" href="#docs-horarios-apertura"><span class="txt-semi-bold">horarios de apertura</span></a> del comercio establecidos previamente por el usuario. En caso que el comercio esté cerrado, los clientes podrán entrar a ver los productos que el comercio ofrece pero no podrán realizar pedidos hasta que abra nuevamente.<br>
                        Para poder recibir pedidos e interactuar con los mismos es necesario que el usuario esté loggeado a la plataforma en el momento en que llegue un nuevo pedido. De todas formas, la plataforma también avisa la llegada de un nuevo pedido a través del correo electrónico establecido por el usuario.
                    </p>
                    <hr>
    
                    <li class="txt-semi-bold docs-title" id="docs-int-pedido-nuevo">Nuevos pedidos</li>
                    <p class="container">
                        Cuando llega un nuevo pedido, la plataforma notifica al usuario a través de una ventana emergente acompañado de un sonido, como así tambíen con una notificación por correo. Para poder ver los nuevos pedidos es necesario presionar el botón <span class="txt-semi-bold">Ver pedidos</span> que aparece en la ventana emergente, o dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('order.new')}}"><span class="txt-semi-bold">Pedidos > Nuevos</span></a>.
                        Dentro de esta sección aparecerán los nuevos pedidos que aún no hayan sido aceptados con sus respectivos detalles. Para aceptar y notificar al cliente que su pedido fue tomado, se debe presionar en el botón <span class="txt-semi-bold">Aceptar</span> y la plataforma automáticamente abrirá una nueva ventana que redirige al WhatsApp del cliente con un texto preestablecido que incluye el detalle completo del pedido aceptado. 
                        Para que esta acción funcione correctamente es necesario que habilite a {{env("APP_NAME")}} para generar ventanas emergentes en su respectivo navegador. Para habilitar esto, es necesario hacer click en el icono de popup arriba a la derecha y seguir los siguientes pasos: <br>

                            <img class="img-fluid p-2 my-2 rounded border" width="25%" src="{{asset('images/popup.png')}}" alt="">
                            <small class="form-text text-muted">En caso de no encontrar dicho icono, consultar la documentación del navegador correspondiente: 
                                <a target="_autoblank" class="docs-link" href="https://support.google.com/chrome/answer/95472?co=GENIE.Platform%3DDesktop&hl=es"><span class="txt-semi-bold">Chrome</span></a>
                                <a target="_autoblank" class="docs-link" href="https://support.mozilla.org/es/kb/configuracion-excepciones-y-solucion-de-problemas-"><span class="txt-semi-bold">Firefox</span></a>
                                <a target="_autoblank" class="docs-link" href="https://support.microsoft.com/es-es/microsoft-edge/bloquear-elementos-emergentes-en-microsoft-edge-1d8ba4f8-f385-9a0b-e944-aa47339b6bb5"><span class="txt-semi-bold">Edge</span></a>
                            </small>

                        <br>
                        Una vez realizado esto, el pedido se aceptará y aparecerá en la sección de <span class="txt-semi-bold">Aceptados</span>. En caso de querer rechazar el pedido, presionar el botón <span class="txt-semi-bold">Rechazar</span> y también se le enviará automáticamente un mensaje al cliente indicando que el comercio no puede tomar el pedido en este momento.
                        En caso que el pedido se haya demorado en aceptar, la plataforma le indicará un aproximado de los minutos demorados del pedido, en caso que se haya demorado mas de un día, el pedido solo tendrá la opción de Cancelar.

                        <div class="container">
                            <div class="alert alert-primary my-2" style="font-size: .8em" role="alert">
                                <i class="fas fa-exclamation-circle"></i> Nota: Es importante estar atento a los nuevos pedidos y aceptar los mismos para notificar y generar una confianza con el cliente evitando problemas a la hora de hacer pedidos a su comercio a través de la plataforma.
                            </div>
                        </div>
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-pedido-aceptado">Pedidos aceptados</li>
                    <p class="container">
                        Para consultar los pedidos aceptados, es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('order.accepted')}}"><span class="txt-semi-bold">Pedidos > Aceptados</span></a> y allí se podrán ver todos los pedidos que se hayan aceptado y estén en preparación. En esta sección es posible <a class="docs-link" href="#docs-int-editar-pedido"><span class="txt-semi-bold">editar el pedido</span></a>, hablar con el cliente, el cual al hacer click lo redireccionará al WhatsApp del mismo, o <a class="docs-link" href="#docs-int-cancelar-pedido"><span class="txt-semi-bold">Cancelar el pedido</span></a>.
                        Una vez que el pedido haya sido entregado al cliente, es importante <a target="_autoblank" class="docs-link" href="#"><span class="txt-semi-bold">Cerrar el pedido</span></a> para evitar confusiones y establecer un orden en los mismos. Una vez cerrado el pedido, los mismos aparecerán en la sección Cerrados con sus respectivos detalles.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-pedido-cerrado">Pedidos cerrados</li>
                    <p class="container">
                        En esta sección, la cual se puede encontrar yendo a <a target="_autoblank" class="docs-link" href="{{route('order.closed')}}"><span class="txt-semi-bold">Pedidos > Cerrados</span></a> se podrán ver todos los pedidos que ya se hayan cerrado, es decir, que ya hayan sido entregados al cliente con éxito. Cada pedido en este listado tiene un botón llamado <span class="txt-semi-bold">Detalles</span> en donde al hacer click, se puede visualizar el detalle completo del pedido realizado.
                    </p>
                    <hr>
                    <li class="txt-semi-bold docs-title" id="docs-int-editar-pedido" id="docs-int-editar-pedido">Editar pedido</li>
                    <p class="container">
                        Existe la posibilidad de que el cliente decida cambiar algunas características del pedido realizado o que accidentalmente algún producto que el cliente haya pedido, no se encuentre disponible en ese momento. Esta acción viene a solucionar este problema. <br>  
                        Para realizar esta acción es necesario que el pedido esté aceptado. Para poder editar el producto es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('order.accepted')}}"><span class="txt-semi-bold">Pedidos > Aceptados</span></a>, posicionarse en el pedido a editar y presionar el ícono <i class="fas fa-ellipsis-h"></i> seguido de la opción <span class="txt-semi-bold">Editar pedido</span>. 
                        Luego una ventana emergente se mostrará con el detalle del pedido actual en donde se podrán modificar todas las características del pedido como cambiar el método de envío, agregar, eliminar o editar los productos del pedido. A medida que se vayan realizando los cambios, automáticamente se podrá ver como el precio final del pedido va cambiando. 
                        Una vez que la edición está lista, se debe presionar el botón <span class="txt-semi-bold">Confirmar</span> y automáticamente el pedido se actualizará y enviará un WhatsApp al cliente con el detalle del nuevo pedido. Esta acción se puede hacer las veces que sea necesaria siempre y cuando el pedido se encuentre en el estado <span class="txt-semi-bold">Aceptado</span>, una vez que el pedido es cerrado, esta acción deja de estar habilitada para el pedido correspondiente.
                    </p>
                    <hr>
                    <li class="txt-semi-bold docs-title" id="docs-int-cancelar-pedido" id="docs-int-cancelar-pedido">Cancelar pedido</li>
                    <p class="container">
                        En caso que el pedido por algún motivo en particular necesite ser cancelado, existe la posibilidad de hacerlo. Para realizar esta acción es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('order.accepted')}}"><span class="txt-semi-bold">Pedidos > Aceptados</span></a> y presionar en el ícono <i class="fas fa-ellipsis-h"></i> seguido de la opción <span class="txt-semi-bold">Cancelar pedido</span>. Una vez seleccionada esta opción
                        una ventana emergente se mostrará pidiendo la confirmación de la cancelación. Dentro de esta ventana existe también un checkbox que en caso de estar tildado notificará al cliente que su pedido fue cancelado o en caso de no necesitarlo se puede destildar y no se enviará ningún mensaje. 
                        Una vez que el pedido se cancela, éste se borrará y no se podrá revertir la acción.
                    </p>
                </ul>

                <h5 class="txt-bold ml-2" id="docs-datos-comercio">Datos de mi comercio</h5>
                <ul class="list-unstyled border p-4 rounded">
                    <li class="txt-semi-bold docs-title" id="docs-int-editar-datos-comercio">¿Cómo editar los datos de mi comercio?</li>
                    <p class="container">
                        Para editar los datos del comercio es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('restaurant.info')}}"><span class="txt-semi-bold">Configuración > Información</span></a>. Allí se verá un resumen de los datos más importantes del comercio como pueden ser los horarios de apertura y los datos generales del comercio.
                        Para modificar los datos se debe presionar el botón <span class="txt-semi-bold">Editar</span> en la sección de <span class="txt-semi-bold">General</span>. Una vez dentro se podrán editar los datos generales las veces que sea necesario. Algunos de los datos que se muestran en esta sección son visibles al público y brindan información tanto para el cliente como para la plataforma por lo que es importante la veracidad de los mismos.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-que-es-el-slug">¿Qué es el slug?</li>
                    <p class="container">
                        El slug es el identificador que representa al comercio. Esto es útil para buscar los comercios adheridos a la plataforma a traves de la URL <span class="txt-semi-bold">/slugdelcomercio</span>, el cual al ingresarlo redirige al perfil del comercio y al mismo tiempo facilita al cliente la búsqueda desde una URL.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-comidas">Comidas</li>
                    <p class="container">
                        En esta sección es necesario indicar las comidas que realiza el comercio. Esta información es importante para que el cliente que está buscando un comercio que haga alguna comida especifica, pueda filtrar por los comercios que venden dicha comida y encontrarlos más fácilmente como así también para categorizar los comercios de la plataforma.
                    </p>
                </ul>

                <h5 class="txt-bold ml-2" id="docs-horarios-apertura">Horarios de apertura</h5>
                <ul class="list-unstyled border p-4 rounded">
                    <li class="txt-semi-bold docs-title" id="docs-int-editar-horarios">¿Cómo editar los horarios de apertura?</li>
                    <p class="container">
                        Para editar los horarios de apertura del comercio es necesario dirigirse a la sección <a target="_autoblank" class="docs-link" href="{{route('restaurant.info')}}"><span class="txt-semi-bold">Configuración > Información</span></a>. Allí se verá un resumen de los datos más importantes del comercio como son los horarios de apertura y los datos generales del comercio. 
                        Para modificar o establecer los horarios de apertura del comercio es necesario presionar en el botón <span class="txt-semi-bold">Editar</span> en la sección de <span class="txt-semi-bold">Horarios</span>.
                        Una vez dentro se mostrarán campos para establecer los horarios de cada día. Por defecto, esta establecido para horarios de dos turnos en los cuales se debe establecer los horarios de apertura y cierre en cada turno. En caso que el comercio abra sólo un turno o haga horario de corrido, dejar sin completar los datos del segundo turno.
                        Es importante que se presione el checkbox que indica que ese día está abierto. Esta función esta pensada para que en casos especiales que un día no se abra, se pueda deshabilitar dicho día sin necesidad de borrar todos los horarios establecidos anteriormente.
                        <div class="container">
                            <div class="alert alert-primary" style="font-size: .8em" role="alert">
                                <i class="fas fa-exclamation-circle"></i> Nota: Es importante que los horarios de apertura y cierre estén establecidos correctamente ya que sólo se podrán realizar pedidos cuando el comercio se encuentre abierto, de lo contrario, la plataforma no permitirá realizar pedidos al comercio.
                            </div>

                            <div class="alert alert-primary" style="font-size: .8em" role="alert">
                                <i class="fas fa-exclamation-circle"></i> Nota: En caso de cerrar a las 00:00hs, por favor indicar 23:59 para que funcione correctamente. Estamos trabajando en una mejora para evitar este inconveniente, sepa disculpar.
                            </div>
                        </div>

                    </p>
                </ul>

                <h5 class="txt-bold ml-2" id="docs-datos-personales">Mis datos personales</h5>
                <ul class="list-unstyled border p-4 rounded">
                    <p class="container">
                        Para acceder a los datos personales del usuario se debe dirigir a la esquina superior derecha donde se muestra el nombre del usuario y allí se desplegarán las opciones disponibles.
                    </p>
                    <li class="txt-semi-bold docs-title" id="docs-int-direcciones">Direcciones</li>
                    <p class="container">
                        En esta sección se encuentran todas las direcciones guardadas del usuario. No es obligatorio guardar las direcciones a la hora de realizar un pedido, pero en caso que la dirección se repita en cada pedido, guardarla es una buena opción.
                        <br>Para <span class="txt-semi-bold">agregar una dirección</span> se debe presionar el botón <span class="txt-semi-bold">Agregar dirección</span> y una ventana emergente aparecerá para rellenar los datos de la misma. Una vez establecidos los datos, presionar en <span class="txt-semi-bold">Agregar</span> y listo, la dirección permanecerá guardada y disponible cada vez que el usuario la solicite.
                        <br>Para <span class="txt-semi-bold">eliminar una dirección</span> se debe presionar el ícono <i class="fas fa-trash-alt"></i> y confirmar la acción. Esta acción es destructiva y no se puede volver atrás una vez hecha.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-pedidos">Pedidos</li>
                    <p class="container">
                        En esta sección el usuario podrá encontrar un listado con todos los pedidos realizados alguna vez. En cada pedido, se podrá ver el estado del mismo y un botón que al presionarlo muestra los detalles del mismo. Esta función permite al usuario tener un seguimiento del pedido en transcurso o los pedidos realizados en algún momento.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-datos">Datos</li>
                    <p class="container">
                        En esta sección el usuario podrá modificar sus datos personales. Es importante establecer datos reales para el correcto funcionamiento de la plataforma y la comunicación con los comercios en caso de realizar un pedido. Para modificar los mismos es necesario presionar el botón <span class="txt-semi-bold">Editar datos</span>, completar los campos necesario y guardar los mismos.
                    </p>
                    <hr>

                    <li class="txt-semi-bold docs-title" id="docs-int-cambiar-contrasena">Cambiar contraseña</li>
                    <p class="container">
                        Para cambiar la contraseña es necesario presionar el botón <span class="txt-semi-bold">Cambiar contraseña</span>, una vez presionado la plataforma lo redirigirá a una nueva página en donde deberá poner el correo electrónico correspondiente del usuario. Una vez ingresado el correo presionar el botón  <span class="txt-semi-bold">Enviar un mensaje para reestablcer contraseña</span> y la plataforma le enviará un correo con un enlace para poder establecer una nueva contraseña.
                    </p>
                </ul>
            </div>
        </div>
</div>

    @endsection