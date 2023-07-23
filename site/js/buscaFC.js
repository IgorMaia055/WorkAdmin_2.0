
function buscaFC(){
    let mesSelect = document.getElementById('select_mes')

    $(document).ready(function (){
        $.ajax({
            url: "{{ url('buscaFluxoCaixa/') }}",
            method: 'POST',
            data: {
                'mes': mesSelect.value
            },
            success: function (data) {
                let dados = JSON.parse(data)
                goDados(dados)
                goFluxoCaixa(dados)
            }
        })

        function goFluxoCaixa(dados){
            let entradaFluxoCaixa = document.getElementById('entradaFC')
            entradaFluxoCaixa.innerHTML = ''
            for(let a=0; a < dados.entradaInfo.length; a++){
                entradaFluxoCaixa.innerHTML += '<div class="list-group-item list-group-item-action d-flex gap-3 py-3" style="text-align: start;"><svg class="bi pe-none flex-shrink-0" width="32" height="32" role="img" aria-label="orcamento"><use xlink:href="#orcamento"></use></svg><div class="d-flex gap-2 w-100 justify-content-between"><div><h6 class="mb-0" id="nomeCarro'+ dados.entradaInfo[a].id +'">  </h6><p class="mb-0 opacity-75" id="dataEntrada'+ dados.entradaInfo[a].id +'"> </p></div><small class="text-success text-nowrap"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg><span id="valorOrcamento'+ dados.entradaInfo[a].id +'">  </span></small></div></div>'

                for(let i=0; i < dados.orcamentos.length; i++){
                    if(dados.entradaInfo[a].id_orcamento == dados.orcamentos[i].id){
                        document.getElementById('nomeCarro'+ dados.entradaInfo[a].id).innerHTML = dados.orcamentos[i].carro
                        document.getElementById('dataEntrada'+ dados.entradaInfo[a].id).innerHTML = ((dados.entradaInfo[a].data_time).substring(0, 10)).split('-').reverse().join('/')
                        document.getElementById('valorOrcamento'+ dados.entradaInfo[a].id).innerHTML = ((dados.orcamentos[i].total).includes('R$') ? (dados.orcamentos[i].total) : 'R$ '+(dados.orcamentos[i].total))
                    }
                }
            }
        }

        function goDados(dados){
            let n1 = 0
            let n2 = 0
            let n3 = 0
            let n4 = 0
            let n5 = 0

            if(dados.entradaInfo.length != 0){

                let valorTotalReceita = 0;

                for(let i =0; i < dados.entradaInfo.length; i++){
                    valorTotalReceita += Number(dados.entradaInfo[i].valor)
                }

                let interval1 = setInterval(() => {
                    if(n1 < valorTotalReceita){
                        n1 += (valorTotalReceita / 50)
                        document.getElementById('entradas').innerHTML = n1.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                    }else{
                        document.getElementById('entradas').innerHTML = valorTotalReceita.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                        clearInterval(interval1)
                    }
                }, 10);

                let interval2 = setInterval(() => {
                    if(n2 <= dados.saida){
                        n2 += (dados.saida / 50)
                        document.getElementById('saidas').innerHTML = n2.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                    }else{
                        document.getElementById('saidas').innerHTML = (dados.saida).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                        clearInterval(interval2)
                    }
                }, 10);

                let lucroMesTotal = valorTotalReceita - dados.saida
                let totalFC = valorTotalReceita + dados.saida

                let interval3 = setInterval(() => {
                    if(n3 < lucroMesTotal){
                        n3 += (lucroMesTotal / 50)
                        document.getElementById('lucroMes').innerHTML = n3.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                    }else{
                        document.getElementById('lucroMes').innerHTML = lucroMesTotal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                        clearInterval(interval3)
                    }
                }, 10);

                let percentEntrada = ((valorTotalReceita * 100) / totalFC).toFixed(2)

                let interval4 = setInterval(() => {
                    if(n4 < percentEntrada){
                        n4 += (percentEntrada / 50)
                        document.getElementById('percentEntrada').innerHTML = n4.toFixed(2) + '%'
                    }else{
                        document.getElementById('percentEntrada').innerHTML = percentEntrada + '%'
                        clearInterval(interval4)
                    }
                }, 10);

                let percentSaida = ((dados.saida * 100) / totalFC).toFixed(2)

                let interval5 = setInterval(() => {
                    if(n5 < percentSaida){
                        n5 += (percentSaida / 50)
                        document.getElementById('percentSaida').innerHTML = n5.toFixed(2) + '%'
                    }else{
                        document.getElementById('percentSaida').innerHTML = percentSaida + '%'
                        clearInterval(interval5)
                    }
                }, 10);
            }else{
                document.getElementById('entradas').innerHTML = n1.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                document.getElementById('saidas').innerHTML = n2.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                document.getElementById('lucroMes').innerHTML = n3.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                document.getElementById('percentEntrada').innerHTML = n4.toFixed(2) + '%'
                document.getElementById('percentSaida').innerHTML = n5.toFixed(2) + '%'
            }
        }
    })
}


buscaFC()