{% extends 'layouts/index.volt' %}

    {% block content %}

        <div id="cadastro_ticket" class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-plus"></i>
                        &nbsp;Editar Noticia
                    </div>
                    {{ form('noticias/update', 'method': 'post', 'enctype' : 'multipart/form-data', 'name':'cadastrar') }}
                        {{ flash.output() }}
                        <div class="panel-body">
                            <div class="col-md-12"  id="conteudo">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <p><strong>Data de Criação:</strong> {{ noticia.getDateCreated() }}</p>
                                                <p><strong>Data da Última Atualização:</strong> {{ noticia.getDateModified() }}</p>
                                                {% if noticia.data_publicacao %} 
                                                    <p><strong>Data Para a publicação:</strong> {{ noticia.getDatePublication() }}</p>
                                                {% endif %}
                                            </div>
                                            
                                            {% if noticia.data_publicacao %} {% else %}
                                                <div class="form-group col-sm-12">
                                                    <label for ="publicar">
                                                        Publicar? <input type="checkbox" id="publicar" name="publicar" class="form-control">
                                                    </label>
                                                </div>
                                                <div id="publication_date_row" class="form-group col-sm-12" style="display: none;">
                                                    <label for ="publication_date">Data Para a publicação</label>
                                                    <input type="datetime-local" id="publication_date" name="publication_date" class="form-control" style="width: 100%;">
                                                </div>
                                            {% endif %}                                            
                                            
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for ="Titulo">Título <span class="error">(*)<span></label>
                                                <input type="text" name="titulo" value="{{ noticia.titulo }}" width='100%' class= "form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for ="Texto">Texto</label>
                                                <textarea class= "form-control" name="texto">{{ noticia.texto }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for ="categories">Categorias</label>
                                                <select id="categories" name="categories[]" class="form-control" style="width: 100%;" multiple>
                                                    {% if categoriesIt is iterable %}
                                                        {% for category in categoriesIt %}
                                                            <option value="{{ category.id }}" {% if utility.searchIdInResultSet(noticia.NoticiaCategory, category.id) %} selected {% endif %} >{{ category.name }}</option>
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>
                                        </div>
                                    </div>{#/.panel-body#}
                                </div>{#/.panel#}
                                <div class="row" style="text-align:right;">
                                    <div id="buttons-cadastro" class="col-md-12">
                                        <a href="{{ url(['for':'noticia.lista']) }}" class="btn btn-default">Cancelar</a>
                                        {{ submit_button('Gravar', "class": 'btn btn-primary') }}
                                    </div>
                                    <input type="hidden" name="id" value="{{ noticia.id }}">
                                </div>
                            </div>{#/.conteudo#}
                        </div>{#/.panel-body#}
                    {{ end_form() }}
                </div>{#/.panel#}
            </div>{#/.col-md-12#}
        </div><!-- row -->

    {% endblock %}

    {%  block extrafooter %}
        
        <script>
            $(document).ready(function(){


            });
        </script>
    {% endblock %}
