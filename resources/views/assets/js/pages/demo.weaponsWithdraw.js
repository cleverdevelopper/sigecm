/*$(document).ready(function () {
  // URL da API que retorna os funcionários
  var apiUrl = 'http://localhost:8888/sigecm/api/funcionarios';

  // Carregar os dados dos funcionários da API assim que a página for carregada
  $.ajax({
      url: apiUrl, // URL da sua API
      method: 'GET',
      dataType: 'json',
      success: function (data) {
          // Verificar se a resposta é válida
          if (Array.isArray(data) && data.length > 0) {
              // Mapear os dados para extrair os nomes dos funcionários e os dados completos
              var funcionarios = data.map(function (funcionario) {
                  return {
                      id: funcionario.codigo_funcionario,
                      name: funcionario.name,
                      cargo: funcionario.cargo,
                      departamento: funcionario.departamento,
                      documento: funcionario.documento,
                      fotografia: funcionario.fotografia,
                      genero: funcionario.genero,
                      patente: funcionario.patente, 
                      nome_departamento: funcionario.nome_departamento, 
                      criado_em: funcionario.criado_em // Supondo que esse campo seja disponibilizado
                  };
              });

              // Inicializar o Typeahead com os dados recebidos
              $("#prefetch").typeahead(
                  { hint: true, highlight: true, minLength: 1 },
                  {
                      name: "funcionarios",
                      source: function (query, process) {
                          var results = [];
                          var substrRegex = new RegExp(query, "i");
                          // Filtrar os resultados que correspondem à pesquisa
                          $.each(funcionarios, function (index, funcionario) {
                              if (substrRegex.test(funcionario.name)) {
                                  results.push(funcionario);
                              }
                          });
                          process(results);
                      },
                      display: function (funcionario) {
                          return funcionario.name; // Exibir o nome no input
                      }
                  }
              );

              // Evento de seleção do nome
              $('#prefetch').on('typeahead:selected', function (e, funcionario) {
                  // Preencher os campos com os dados do funcionário selecionado
                  $("#funcionario-nome").text(funcionario.name);
                  $("#departamento").text(funcionario.departamento);
                  $("#departamento1").text(funcionario.departamento);
                  $("#avatar").attr("src", 'images/' + funcionario.fotografia); // Ajuste o caminho da imagem
                  $("#sobre").text(funcionario.sobre || 'Sobre não disponível');
                  $("#full-name").text(funcionario.name);
                  $("#full-name1").text(funcionario.name);
                  $("#gender").text(funcionario.genero || 'Não disponível');
                  $("#patente").text(funcionario.patente || 'Não disponível');
                  $("#patente1").text(funcionario.patente || 'Não disponível');
                  $("#patente2").text(funcionario.patente || 'Não disponível');
                  $("#cargo").text(funcionario.cargo || 'Não disponível');
                  $("#cargo1").text(funcionario.cargo || 'Não disponível');
                  $("#cargo2").text(funcionario.cargo || 'Não disponível');
                  $("#documento").text(funcionario.documento || 'Não disponível');


                  
              });
          } else {
              console.error('Erro: Dados de funcionários não encontrados.');
          }
      },
      error: function (xhr, status, error) {
          console.error('Erro na requisição à API:', error);
      }
  });
});*/


$(document).ready(function () {
    // URL da API que retorna os funcionários
    var apiUrl = 'http://localhost:8888/sigecm/api/funcionarios';
 
    // Carregar os dados dos funcionários da API assim que a página for carregada
    $.ajax({
        url: apiUrl, // URL da sua API
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Verificar se a resposta é válida
            if (Array.isArray(data) && data.length > 0) {
                // Mapear os dados para extrair os nomes dos funcionários e os dados completos
                var funcionarios = data.map(function (funcionario) {
                    return {
                        id: funcionario.id,
                        name: funcionario.name,
                        cargo: funcionario.cargo,
                        departamento: funcionario.departamento,
                        documento: funcionario.documento,
                        fotografia: funcionario.fotografia,
                        genero: funcionario.genero,
                        patente: funcionario.patente, 
                        nome_departamento: funcionario.nome_departamento, 
                        celular: funcionario.celular, 
                        celular_alt: funcionario.celular_alt, 
                        criado_em: funcionario.criado_em // Supondo que esse campo seja disponibilizado
                    };
                });
 
                // Inicializar o Typeahead com os dados recebidos
                $("#prefetch").typeahead(
                    { hint: true, highlight: true, minLength: 1 },
                    {
                        name: "funcionarios",
                        source: function (query, process) {
                            var results = [];
                            var substrRegex = new RegExp(query, "i");
                            // Filtrar os resultados que correspondem à pesquisa
                            $.each(funcionarios, function (index, funcionario) {
                                if (substrRegex.test(funcionario.name)) {
                                    results.push(funcionario);
                                }
                            });
                            process(results);
                        },
                        display: function (funcionario) {
                            return funcionario.name; // Exibir o nome no input
                        }
                    }
                );
 
                // Evento de seleção do nome
                $('#prefetch').on('typeahead:selected', function (e, funcionario) {
                    // Preencher os campos visíveis
                    $("#funcionario-nome").text(funcionario.name);
                    $("#departamento").text(funcionario.departamento);
                    $("#departamento1").text(funcionario.departamento);
                    $("#avatar").attr("src", 'images/Funcionarios/' + funcionario.fotografia); // Ajuste o caminho da imagem
                    $("#sobre").text(funcionario.sobre || 'Sobre não disponível');
                    $("#full-name").text(funcionario.name);
                    $("#full-name1").text(funcionario.name);
                    $("#gender").text(funcionario.genero || 'Não disponível');
                    $("#patente").text(funcionario.patente || 'Não disponível');
                    $("#patente1").text(funcionario.patente || 'Não disponível');
                    $("#patente2").text(funcionario.patente || 'Não disponível');
                    $("#cargo").text(funcionario.cargo || 'Não disponível');
                    $("#cargo1").text(funcionario.cargo || 'Não disponível');
                    $("#cargo2").text(funcionario.cargo || 'Não disponível');
                    $("#documento").text(funcionario.documento || 'Não disponível');

                    // Preencher os campos ocultos
                    $("#hiddenCodigo").val(funcionario.id || 'Não disponível');
                    $("#hiddenPatente").val(funcionario.patente || 'Não disponível');
                    $("#hiddenFullName").val(funcionario.name);
                    $("#hiddenDepartamento").val(funcionario.departamento);
                    $("#hiddenCargo").val(funcionario.cargo);
                    $("#hiddenGenero").val(funcionario.genero || 'Não disponível');
                    $("#hiddenDocumento").val(funcionario.documento || 'Não disponível');
                    $("#hiddenCelular").val(funcionario.celular || 'Não disponível');
                    $("#hiddenCelularAlt").val(funcionario.celular_alt || 'Não disponível');
                    $("#hiddenFotografia").val(funcionario.fotografia || 'Não disponível');
                });
            } else {
                console.error('Erro: Dados de funcionários não encontrados.');
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro na requisição à API:', error);
        }
    });
});
