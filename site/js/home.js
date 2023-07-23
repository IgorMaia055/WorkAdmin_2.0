function roteCard(id_rote, id_cardBody){
    let rote1 = document.getElementById('rote1')
    let rote2 = document.getElementById('rote2')
    let rote3 = document.getElementById('rote3')
    let cardBody1 = document.getElementById('cardBody1')
    let cardBody2 = document.getElementById('cardBody2')
    let cardBody3 = document.getElementById('cardBody3')

    if(id_rote == 'rote1'){
      rote1.classList = 'nav-link link-body-emphasis active'
      rote2.classList = 'nav-link link-body-emphasis'
      rote3.classList = 'nav-link link-body-emphasis'
      document.querySelector('.pSmall').innerHTML = 'Clique para confimar o pagamento'
    }else if(id_rote == 'rote2'){
      rote1.classList = 'nav-link link-body-emphasis'
      rote2.classList = 'nav-link link-body-emphasis active'
      rote3.classList = 'nav-link link-body-emphasis'
    }else if(id_rote == 'rote3'){
      rote1.classList = 'nav-link link-body-emphasis'
      rote2.classList = 'nav-link link-body-emphasis'
      rote3.classList = 'nav-link link-body-emphasis active'
      document.querySelector('.pSmall').innerHTML = 'Clique para excluir a conta'
    }

    if(id_cardBody == 'cardBody1'){
      cardBody1.hidden = false
      cardBody2.hidden = true
      cardBody3.hidden = true
    }else if(id_cardBody == 'cardBody2'){
      cardBody1.hidden = true
      cardBody2.hidden = false
      cardBody3.hidden = true
    }else if(id_cardBody == 'cardBody3'){
      cardBody1.hidden = true
      cardBody2.hidden = true
      cardBody3.hidden = false
    }
}

function roteCard2(id_rote, id_cardBody){
    let rote1 = document.getElementById('roteFC1')
    let rote2 = document.getElementById('roteFC2')
    let cardBody1 = document.getElementById('cardBodyFC1')
    let cardBody2 = document.getElementById('cardBodyFC2')

    if(id_rote == 'roteFC1'){
      rote1.classList = 'nav-link link-body-emphasis active'
      rote2.classList = 'nav-link link-body-emphasis'
      rote3.classList = 'nav-link link-body-emphasis'
    }else if(id_rote == 'roteFC2'){
      rote1.classList = 'nav-link link-body-emphasis'
      rote2.classList = 'nav-link link-body-emphasis active'
      rote3.classList = 'nav-link link-body-emphasis'
    }

    if(id_cardBody == 'cardBodyFC1'){
      cardBody1.hidden = false
      cardBody2.hidden = true
      cardBody3.hidden = true
    }else if(id_cardBody == 'cardBodyFC2'){
      cardBody1.hidden = true
      cardBody2.hidden = false
      cardBody3.hidden = true
    }
}


function deleteElemento(id){
          $.ajax({
              url: "{{ url('delete_conta_paga/') }}",
              method: 'POST',
              data: {
                'id': id
              },
              success: function (data) {
                if(data == 'ok'){
                  window.location.href="{{ url('home/') }}"
                }
              }
          })
}

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

          function goDados(dados){
            let n1 = 0
            let n2 = 0
            let n3 = 0
            let n4 = 0
            let n5 = 0

            if(dados.receitaTotal != 0){

              let interval1 = setInterval(() => {
                if(n1 < dados.entrada){
                  n1 += (dados.entrada / 50)
                  document.getElementById('entradas').innerHTML = n1.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                }else{
                  document.getElementById('entradas').innerHTML = (dados.entrada).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
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

              let interval3 = setInterval(() => {
                if(n3 < dados.receitaTotal){
                  n3 += (dados.receitaTotal / 50)
                  document.getElementById('receitaTotal').innerHTML = n3.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                }else{
                  document.getElementById('receitaTotal').innerHTML = (dados.receitaTotal).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                  clearInterval(interval3)
                }
              }, 10);

              let interval4 = setInterval(() => {
                if(n4 < dados.percentEntrada){
                  n4 += (dados.percentEntrada / 50)
                  document.getElementById('percentEntrada').innerHTML = n4.toFixed(2) + '%'
                }else{
                  document.getElementById('percentEntrada').innerHTML = dados.percentEntrada.toFixed(2) + '%'
                  clearInterval(interval4)
                }
              }, 10);

              let interval5 = setInterval(() => {
                if(n5 < dados.percentSaida){
                  n5 += (dados.percentSaida / 50)
                  document.getElementById('percentSaida').innerHTML = n5.toFixed(2) + '%'
                }else{
                  document.getElementById('percentSaida').innerHTML = dados.percentSaida.toFixed(2) + '%'
                  clearInterval(interval5)
                }
              }, 10);
            }else{
              document.getElementById('entradas').innerHTML = n1.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
              document.getElementById('saidas').innerHTML = n2.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
              document.getElementById('receitaTotal').innerHTML = n3.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
              document.getElementById('percentEntrada').innerHTML = n4.toFixed(2) + '%'
              document.getElementById('percentSaida').innerHTML = n5.toFixed(2) + '%'
            }
          }
  })
}

buscaFC()