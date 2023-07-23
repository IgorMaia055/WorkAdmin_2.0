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
        cardBody2.hidden = true;
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