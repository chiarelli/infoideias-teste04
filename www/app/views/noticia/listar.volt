{% extends 'layouts/index.volt' %}

    {%  block extrafooter %}
        <link href="{{ static_url("css/datatables.min.css") }}" rel="stylesheet">
    {% endblock %}

    {% block content %}
            <div class="row">
                <div class="col-md-12" id="conteudo">
                    <!-- <div class="col-md-6 col-sm-6"> -->
                        <div class="panel panel-default">
                            {{ flash.output() }}
                            <div class="panel-heading">
                                <!-- <a href="#" class="pull-right">View all</a> -->
                                <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                                &nbsp;Notícias
                                <form class="navbar-form navbar-right" id="search_ticket" role="search">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                            <input id="dataTableSearch" type="text" class="form-control" placeholder="Search">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-body">                                
                                <div class="col-md-12">
                                    <a id="button-abrir-ticket" href="{{ url(['for':'noticia.cadastrar']) }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Nova Noticia</a>
                                    
                                </div>
								<table id="lista-noticia" class="table dataTable table-hover">
									<thead>
										<tr>
											<td>Cod</td>
											<td>Titulo</td>
											<td>Texto</td>
											<td>Ações</td>
										</tr>
									</thead>
									<tbody>
										<tr>
                                            <td><a href="#">#1</a></td>
                                            <td class="titulo"> Título</td>
                                            <td class="text-center">Texto</td>
                                            <td>
                                                <a href="{{ url(['for':'noticia.editar',"id":1]) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <a href="{{ url(['for':'noticia.excluir',"id":1]) }}"><span class="glyphicon glyphicon-remove-sign"></span></a>
                                            </td>
										</tr>
                                        <tr>
                                            <td><a href="#">#2</a></td>
                                            <td class="titulo"> Título 2</td>
                                            <td class="text-center">Texto 2</td>
                                            <td>
                                                <a href="{{ url(['for':'noticia.editar',"id":2]) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <a href="{{ url(['for':'noticia.excluir',"id":2]) }}"><span class="glyphicon glyphicon-remove-sign"></span></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">#3</a></td>
                                            <td class="titulo"> Título 3</td>
                                            <td class="text-center">Texto 3</td>
                                            <td>
                                                <a href="{{ url(['for':'noticia.editar',"id":3]) }}"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <a href="{{ url(['for':'noticia.excluir',"id":3]) }}"><span class="glyphicon glyphicon-remove-sign"></span></a>
                                            </td>
                                        </tr>
									</tbody>
								</table>
                            </div><!-- panel-body -->
                        </div>
                </div>
            </div><!-- row -->

    {% endblock %}

    {%  block extrafooter %}
        

        <script>

            $(document).ready(function(){

                
            });
        </script>


    {% endblock %}