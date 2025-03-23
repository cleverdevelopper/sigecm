$(document).ready(function () {
    // URL da API que retorna os dados do armamento
    const apiUrl = 'http://localhost:8888/sigecm/api/armamento';

    // Carregar os dados do armamento da API assim que a página for carregada
    $.ajax({
        url: apiUrl, // URL da API
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Verificar se a resposta contém os dados esperados
            if (Array.isArray(data) && data.length > 0) {
                // Mapear os dados para extrair as informações do armamento
                const armamentos = data.map( function (item) {
                    return{
                        id: item.id,
                        numero_serie: item.numero_serie,
                        tipo: item.tipo,
                        estado_codigo: item.estado,
                        estado: item.estado_desc,
                        calibre: item.calibre,
                        data_inspensao: item.data_inspensao
                    };

                    
                });

                // Inicializar o Typeahead para o campo "Numero de Serie do Armamento"
                $("#prefetch_weapons").typeahead(
                    {
                        hint: true, 
                        highlight: true, 
                        minLength: 1 
                    },
                    {
                        name: "armamentos",
                        source: function (query, process) {
                            const results = [];
                            const substrRegex = new RegExp(query, "i");
                            
                            // Filtrar os resultados que correspondem à pesquisa
                            $.each(armamentos, function (index, item) {
                                if (substrRegex.test(item.numero_serie)) {
                                    results.push(item);
                                }
                            });
                            process(results);
                        },
                        display: function (item) {
                            return item.numero_serie; // Exibir o número de série no input
                        }
                    }
                );

                // Evento de seleção do número de série
                $('#prefetch_weapons').on('typeahead:selected', function (e, item) {
                    // Preencher os campos com os dados do armamento selecionado
                    $("#tipo_arma").val(item.tipo); // Tipo da Arma
                    $("#estado_Arma").val(item.estado); // Estado da Arma
                    $("#municao").val(item.calibre); // Calibre da Municao
                    $("#data_inspencao").val(item.data_inspensao); // Data da Última Inspeção

                    // Preencher o campo hidden com o código da arma (não a data de inspeção)
                    $("#text_hiddenArmamento").val(item.id || 'Não disponível');
                    $("#hiddenEstado").val(item.estado_codigo || 'Não disponível');
                });
            } else {
                console.error('Erro: Dados de armamento não encontrados ou resposta inválida.');
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro na requisição à API:', error);
        }
    });
});
