/**
 * Created by rodrigo.martins on 13/01/2016.
 */

var lat;
var lng;


$("ul[id*=myid] li").click(function () {
    var cod_familia = this.id;
    var cod_pro = this.getAttribute("data-cod_pro");
    var cod_texto = this.getAttribute("data-cod_texto");
    var op = this.getAttribute("data-op");
    descricao_familia(cod_familia, cod_pro, op, cod_texto);
});


$('.data_table').DataTable({
    responsive: true,
    columnDefs: [
        {responsivePriority: 1, targets: 0},
        {responsivePriority: 2, targets: -2}
    ],
    language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.10/i18n/Portuguese-Brasil.json"
    }
});

$('.data_table_off').DataTable({
    responsive: true,
    language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.10/i18n/Portuguese-Brasil.json"
    },
    bPaginate: false,
    bLengthChange: false,
    bFilter: false,
    bInfo: false,
    bAutoWidth: false,
    ordering: false
});

/*
function pesquisa() {

    var edtp = document.getElementById("pesquisa").value;
    var numpg = document.getElementById("regpag").value;

    if (edtp == "") {

        msgerro("erro", "Sua Busca não retornou resultados. Informe pelo menos uma palavra", "danger", 8000);

        document.getElementById("paginacao").innerHTML = "";
        document.getElementById("corpo").innerHTML = "";

    }
    else {
        location.href = "pesquisa.php?pesquisa=" + edtp + "&pg=1&numpg=" + numpg;
    }


}
*/

function pesquisageral() {

    var edtp = document.getElementById("pesquisa_1").value;
    var numpg = 8;


    location.href = "pesquisa.php?pesquisa=" + edtp + "&pg=1&numpg=" + numpg;


}

/*
function enter_geral() {
    if (event.keyCode == 13) {
        pesquisageral()
    }
}
function enter() {
    if (event.keyCode == 13) {
        pesquisa()
    }
}


document.onkeydown = enter;

*/
function buscar_cep(n) {
    var endereco = document.getElementById("endereco");
    var bairro = document.getElementById("bairro");
    var cidade = document.getElementById("cidade");
    var uf = document.getElementById("uf");
    var numero = document.getElementById("numero");

    n = n.replace("-", "");
    var resposta;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            resposta = JSON.parse(xmlhttp.responseText);
            endereco.value = resposta.logradouro;
            bairro.value = resposta.bairro;
            cidade.value = resposta.cidade;
            uf.value = resposta.uf;
            var adress = resposta.logradouro + ", " + numero.value + ", " + resposta.cidade;
            get_coords(adress);
        }

        numero.focus();
        numero.select();

    };
    xmlhttp.open("GET", "http://api.postmon.com.br/v1/cep/" + n, true);
    xmlhttp.send();
}


function get_coords(adress) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var json = JSON.parse(xmlhttp.responseText);
            lng = json.results[0].geometry.location.lng;
            lat = json.results[0].geometry.location.lat;
            initialize();
        }

    };
    xmlhttp.open("GET", "http://maps.google.com/maps/api/geocode/json?address=" + adress + "&sensor=false", true);
    xmlhttp.send();
}




function add_video() {
    var url = document.getElementById('url_video');

    if (url.value != "") {

        var div = document.getElementById('videos');
        var id = getQueryString('v', url.value);
        div.innerHTML += "<div class='alert alert-default alert-dismissible arquivo_video col-xs-12 col-sm-12 col-lg-offset-1 col-lg-4 panel panel-default center-block' role='alert' data-codigo='" + id + "'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><iframe width='300' height='200' src='https://www.youtube.com/embed/" + id + "' frameborder='0' allowfullscreen></iframe></li></div>";
        div.innerHTML += "<input type='hidden' value='" + url.value + "' name='video_" + id + "' id='video_" + id + "'/>";
        url.value = "";
    }
}


$('.arquivo_pdf').on('closed.bs.alert', function () {
    var codigo = this.getAttribute('data-codigo');
    console.log(codigo);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
        }
    };
    xhttp.open("GET", "../backend/delete_arquivo_pdf.php?codigo=" + codigo, true);
    xhttp.send();

});


$('.arquivo_video').on('closed.bs.alert', function () {
    var id = this.getAttribute('data-codigo');
    document.getElementById(id).remove();
});


var table = $('#table_veiculos').DataTable();

$('#table_veiculos tbody').on('click', 'button.excluir_tr', function () {
    table
        .row($(this).parents('tr'))
        .remove()
        .draw();

    var input = this.parentNode;
    input = input.parentNode;
    input = input.getElementsByTagName('input');
    input[0].remove();
});

var modal_veiculos = $('#modal_veiculos');

$('#add_veiculo').on('click', function () {

    var slt_fabricante = document.getElementById('slt_fabricante');
    var slt_modelo = document.getElementById('slt_modelo');
    var ipt_versao = document.getElementById('ipt_versao');
    var ipt_inicial = document.getElementById('ipt_inicial');
    var ipt_final = document.getElementById('ipt_final');
    var ipt_acima = document.getElementById('ipt_acima');
    var ipt_sistema = document.getElementById('ipt_sistema');

    slt_fabricante.value = "";
    slt_modelo.value = "";
    slt_modelo.disabled = true;
    ipt_versao.value = "";
    ipt_inicial.value = "";
    ipt_inicial.style.display = "block";
    ipt_final.value = "";
    ipt_final.style.display = "block";
    ipt_acima.value = "";
    ipt_acima.style.display = "block";
    ipt_sistema.value = "";


    modal_veiculos.modal('show');
});

function add_veiculo() {

    var slt_fabricante = document.getElementById('slt_fabricante');
    var slt_modelo = document.getElementById('slt_modelo');
    var ipt_versao = document.getElementById('ipt_versao');
    var ipt_inicial = document.getElementById('ipt_inicial');
    var ipt_final = document.getElementById('ipt_final');
    var ipt_acima = document.getElementById('ipt_acima');
    var ipt_sistema = document.getElementById('ipt_sistema');

    var json = {
        cod_fabricante: slt_fabricante.value,
        cod_veiculo: slt_modelo.value,
        anoini: ipt_inicial.value,
        anofim: ipt_final.value,
        versao: ipt_versao.value,
        sistema: ipt_sistema.value,
        acimade: ipt_acima.value
    };
    json = JSON.stringify(json);

    var ano;
    if (ipt_acima.value != "") {
        ano = "A partir de " + ipt_acima.value;
    } else {
        ano = "De: " + ipt_inicial.value + " Até: " + ipt_final.value;
    }


    table.row.add([
        "",
        slt_fabricante.options[slt_fabricante.selectedIndex].label,
        slt_modelo.options[slt_modelo.selectedIndex].label,
        ano,
        ipt_versao.value,
        ipt_sistema.value,
        "<input type='hidden' id='' name='veiculo_novo_" + Date.now() + "' value='" + json + "'><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-danger excluir_tr'  title='Excluir veículo'><span class='glyphicon glyphicon-minus'></span></bu></div>"
    ]).draw();

    modal_veiculos.modal('hide');

}

var modal_imagens = $('#modal_images');

$('.thun_url').on('click', function () {
    //alert($(this).attr('data-url'));
    $('#url').val($(this).attr('data-url'));
    $('#img_produto').attr('src', $(this).attr('data-url'));
    modal_imagens.modal('hide');
});


function msgerro(id, msg, tipo, tempo) {


    var texto = "<div class='row'>" +
        "<div class='form-group col-md-12'> " +
        "<div id='alertModalEtapas' class='alert alert-" + tipo + "' role='alert' style='display: none'>" + msg + "</div> </div> </div>";

    document.getElementById(id).innerHTML = texto;

    $('#alertModalEtapas').fadeIn();
    $('#alertModalEtapas').fadeOut(tempo);

}

function slt_status() {
    var status = document.getElementById("status");
    var substituido_por = document.getElementById("substituido_por");

    if (status.value == "Substituido") {
        substituido_por.style.visibility = 'visible';
    } else {
        substituido_por.style.visibility = 'hidden';
        substituido_por.value = 0;
    }

}

function slt_fabricante() {
    var slt_fabricante = document.getElementById("slt_fabricante");
    var div_veiculos = document.getElementById("div_veiculos");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            div_veiculos.innerHTML = xhttp.responseText;
        }
    };
    xhttp.open("GET", "../backend/select_modelo.php?cod_fabricante=" + slt_fabricante.value, true);
    xhttp.send();

}


function descricao_familia(cod_familia, cod_produto, op, cod_texto) {

    var cod_texto1 = document.getElementById("cod_texto");
    var detalhamento = document.getElementById("detalhamento");


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log(xhttp.responseText);
            var json = JSON.parse(xhttp.responseText);
            console.log(json[0]);
            cod_texto1.value = cod_texto;
            detalhamento.value = json[0].descricao;
            $("#modal_texto").modal('hide');

        }
    };
    xhttp.open("GET", "../backend/altera_descricao.php?cod_produto=" + cod_produto + "&cod_familia=" + cod_familia + "&tipo_op=" + op + "&cod_texto=" + cod_texto, true);
    xhttp.send();

}


function limpadiv(div) {
    document.getElementById(div).innerHTML = "";
}


function excluir_produto(id) {
    var c = confirm("Tem certeza que deseja excluir esse produto?");
    if (c) {
        location.href = "../backend/delete_produto.php?codigo=" + id;
    }
}

function excluir_representante(id) {
    var d = confirm("Tem certeza que deseja excluir esse representante?");
    if (d) {
        location.href = "../backend/delete_representante.php?codigo=" + id;
    }
}
function excluir_cliente(id) {
    var d = confirm("Tem certeza que deseja excluir esse CLIENTE?");
    if (d) {
        location.href = "../backend/delete_cliente.php?codigo=" + id;
    }
}
function excluir_parceiro(id) {
    var d = confirm("Tem certeza que deseja excluir esse PARCEIRO?");
    if (d) {
        location.href = "../backend/delete_parceiro.php?codigo=" + id;
    }
}
function excluir_aplicacao(id) {
    var d = confirm("Tem certeza que deseja excluir essa aplicação?");
    if (d) {
        location.href = "../backend/delete_aplicacao.php?codigo=" + id;
    }
}
function excluir_fabricante(id) {
    var d = confirm("Tem certeza que deseja excluir esse fabricante?");
    if (d) {
        location.href = "../backend/delete_fabricante.php?codigo=" + id;
    }
}
function excluir_usuario(id) {
    var d = confirm("Tem certeza que deseja excluir esse usuário?");
    if (d) {
        location.href = "../backend/delete_usuario.php?codigo=" + id;
    }
}
function excluir_contrato(id) {

    var a = document.getElementById("obs_cancelamento").value;

    if(a.length<20){
        alert("A justificativa deve ter mais que 20 (vinte) caracteres!");
    }else{
        var d = confirm("Tem certeza que deseja cancelar esse CONTRATO?");
    }
    if (d) {
        location.href = "../backend/delete_contrato.php?codigo=" + id+"&obs_cancelamento="+a;
    }
}
function fn_obs_can() {
    $('#campo_obs_canc').fadeToggle();
    $('#btn_salvar').fadeToggle();
    $('#btn_cancelar').fadeToggle();
}

function fn_obs_voltar() {
    $('#campo_obs_canc').fadeToggle();
    $('#btn_salvar').fadeToggle();
    $('#btn_cancelar').fadeToggle();
}

$('#ipt_final, #ipt_inicial').on('change', function () {
    if ($('#ipt_final, #ipt_inicial').val() != "") {
        $('#ipt_acima').hide();
        $('#ipt_acima').val("");
    } else {
        $('#ipt_acima').show();
        $('#ipt_acima').val("");
    }
});
$('#ipt_acima').on('change', function () {
    if ($('#ipt_acima').val() != "") {
        $('#ipt_final, #ipt_inicial').hide();
        $('##ipt_final, #ipt_inicial').val(0);
    } else {
        $('#ipt_final, #ipt_inicial').show();
        $('##ipt_final, #ipt_inicial').val(0);
    }
});


function meu_mapa() {
    var endereco = document.getElementById("endereco");
    var cidade = document.getElementById("cidade");
    var numero = document.getElementById("numero");
    var adress = endereco.value + ", " + numero.value + ", " + cidade.value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            var json = JSON.parse(xmlhttp.responseText);
            lng = json.results[0].geometry.location.lng;
            lat = json.results[0].geometry.location.lat;
            initialize();
        }

    };
    xmlhttp.open("GET", "http://maps.google.com/maps/api/geocode/json?address=" + adress + "&sensor=false", true);
    xmlhttp.send();
}


if (location.pathname == "/tury/admin/pages/detalhe_parceiro.php") {
    meu_mapa();
}


function fn_pesquisa_cliente() {

    $("#modalLoading").modal("show");

    var ipt_pesquisa_cliente = document.getElementById('ipt_pesquisa_cliente');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var json = JSON.parse(xmlhttp.responseText);
            var str = "<div class='list-group'>";
            for (var i = 0; i < json.length; i++) {
                str += "<button id='cliente_selected' type='button' class='list-group-item' data-codigo='"+json[i].codigo+"'>" + json[i].nome_razao + " - " + json[i].cpf_cnpj + "</button>";
            }
            str += "</div>";
            $('#myModal').find('.modal-body').html(str);
            $("#modalLoading").modal("hide");
            $('#myModal').modal('show');

        };
    };
    xmlhttp.open("GET", "../backend/pesquisa_cliente.php?p=" + ipt_pesquisa_cliente.value, true);
    xmlhttp.send();
}
$(document).ready(function(){

    $("#cod_fabricante").on('change',function(){
        $("#modalLoading").modal("show");
        $.ajax({
            type: "get",
            url: "../backend/select_modelo.php?cod_fabricante="+this.value,
            success: function(result){
                $("#slt_veiculos").html(result);
                $("#modalLoading").modal("hide");
            }});
    });

    $("#myModal").on('click',function(ev){
        var cod_cliente = ev.target.getAttribute('data-codigo');

        if(cod_cliente) {

            $("#myModal").modal("hide");
            $("#modalLoading").modal("show");
            $.ajax({
                type: "get",
                url: "../backend/select_cliente.php?codigo=" + cod_cliente,
                success: function (result) {
                    //$("#slt_veiculos").html(result);
                    //console.log(result);
                    var json = JSON.parse(result);
                    //console.log(json);
                    for(var x in json[0]){
                        console.log(json[0][x]);
                        if(document.getElementById(x)){
                            document.getElementById(x).value = json[0][x];
                            //console.log(json[0][x]);
                        }
                    }
                    $("#modalLoading").modal("hide");
                }
            });
        }
    });
    $( "#ipt_pesquisa_cliente" ).keypress(function(ev) {
        if(ev.charCode == 13) {
            fn_pesquisa_cliente();
        }
    });

    $('#eq_instal').on('keyup', function(){
        fn_a();
    });

    $("#fp_parcelas_cartao").on('change', function(){
        fn_b();
    });

    $('#mensalidade').on('keyup', function(){
        fn_e();
    });

    $('#t_mensalidade').on('change', function(){
       fn_c();
    });

    $("#me_parcelas").on('change', function(){
        fn_e();
    });



    $('#me_dia_vencimento').on('change', function() {
        var d = new Date(this.value);
        var e = this.value;
        switch (d.getUTCDate()){
            case 10:
                ;
            case 20:
                break;
            case 28:
                if(d.getUTCMonth()!=1){
                    my_alert();
                }
            case 29:
                if(d.getUTCMonth()!=1){
                    my_alert();
                }
            case 30:
                break;
            default :
                my_alert();
        }
        function my_alert(){
            alert("Os dias de vencimento devem ser 10, 20 ou 30\n*Exceto para o mês de fevereito");
            document.getElementById('me_dia_vencimento').value = "";
        }
    });

    $(".money").maskMoney(
        {
            showSymbol: true,
            thousands: '',
            decimal: '.'
        }
    );

    /*
    $('#form_contrato').submit(function(){
        var money = document.getElementsByClassName('money');

        for ( a in money){
            money[a].value = money[a].value.replace(".","");
            money[a].value = money[a].value.replace(",",".");
            console.log(money[a].value);
        }


    });
    */
    fn_a();
    fn_c();
    fn_d();

});

function fn_a(){
    var fp_dinheiro = document.getElementById("fp_dinheiro");
    var fp_boleto = document.getElementById("fp_boleto");
    var fp_deposito = document.getElementById("fp_deposito");
    var fp_cheque = document.getElementById("fp_cheque");
    var fp_cartao_debito = document.getElementById("fp_cartao_debito");
    var fp_cartao_credito = document.getElementById("fp_cartao_credito");
    var fp_parcelas_cartao = document.getElementById("fp_parcelas_cartao");
    var valor_parcela =  document.getElementById("valor_parcela");
    var fp_total = document.getElementById("fp_total");

    var total = 0;

    var a = [
        fp_dinheiro,
        fp_boleto,
        fp_deposito,
        fp_cheque,
        fp_cartao_debito,
        fp_cartao_credito
    ];

    for( b in a){
        total += Number(a[b].value);
    }

    fp_total.value = total.toFixed(2);
    fn_b();
    fn_e();
}
function fn_b(){
    var fp_cartao_credito =  document.getElementById("fp_cartao_credito");
    var fp_parcelas_cartao =  document.getElementById("fp_parcelas_cartao");
    var valor_parcela =  document.getElementById("valor_parcela");
    valor_parcela.value =  (Number(fp_cartao_credito.value) / Number(fp_parcelas_cartao.value)).toFixed(2);
}

function fn_c(){
    var a = document.getElementsByName('tipo_mensalidade');
    $('#dados_conta').fadeOut();
    for( b in a){
        if(a[b].checked && a[b].value == "debito") {
            $('#dados_conta').fadeIn();
        }
    };
}
function fn_d(){
    var a = document.getElementsByName('tipo_mensalidade');
    $('#dados_conta').fadeOut();
    for( b in a){
        if(a[b].checked && a[b].value == "debito"){
            $('#dados_conta').fadeIn();
        };
    }
}

function fn_e(){
    var me_total =  document.getElementById("me_total");
    var me_parcelas =  document.getElementById("me_parcelas");
    var valor_me_parcela =  document.getElementById("valor_me_parcela");

    valor_me_parcela.value =  (Number(me_total.value) / Number(me_parcelas.value)).toFixed(2);
}

/*
function fn_f(){
    var data_instalacao =  document.getElementById("data_instalacao");
    var me_dia_vencimento =  document.getElementById("me_dia_vencimento");
    var y,z;
    var d = new Date(data_instalacao.value);

    var dia = d.getUTCDate();
    var datas = [];

    if(dia<10){
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-10");
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-20");

        if(d.getUTCMonth()==1){
            var x = new Date(d.getUTCFullYear(), (((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1)),0);
            x = x.getUTCDate();
            console.log(x);
            if(x<30){
                datas.push(d.getUTCFullYear()+"-"+((((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1)))+"-"+x);
            }else{
               datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-30");
            }
        }else{
            datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-30");
        }

        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-10");
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-20");

    }else if(dia<20){

        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-20");

        if(d.getUTCMonth()==1){
            var x = new Date(d.getUTCFullYear(), (((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1)),0);
            x = x.getUTCDate();
            if(x<30){
                datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-"+x);
            }else{
                datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-30");
            }
        }else{
            datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-30");
        }
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-10");
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-20");

        if((d.getUTCMonth()+1)==1){
            var x = new Date(d.getUTCFullYear(),(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2)),0);
            x = x.getUTCDate();
            if(x<30){
                datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-"+x);
            }else{
                datas.push(d.getUTCFullYear()+"-"+((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2)+"-30");
            }
        }else{
            datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-30");
        }

    }else if(dia<30){

        if(d.getUTCMonth()==1){
            var x = new Date(d.getUTCFullYear(), (((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2)),0);
            x = x.getUTCDate();
            if(x<30){
                datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-"+x);
            }else{
                datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-30");
            }
        }else{
            datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+1)>12)?'01':(d.getUTCMonth()+1))+"-30");
        }

        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-10");
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-20");

        if((d.getUTCMonth()+1)==1){
            var x = new Date(d.getUTCFullYear(),(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2)),0);
            x = x.getUTCDate();
            if(x<30){
                datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-"+x);
            }else{
                datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-30");
            }
        }else{
            datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-30");
        }

    }else{
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-10");
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-20");

        if(d.getUTCMonth()+1==1){
            var x = new Date(d.getUTCFullYear(), (((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2)),0);
            x = x.getUTCDate();
            if(x<30){
                datas.push(d.getUTCFullYear()+"-"+((((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2)))+"-"+x);
            }else{
                datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-30");
            }
        }else{
            datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+2)>12)?'01':(d.getUTCMonth()+2))+"-30");
        }

        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+3)>12)?'01':(d.getUTCMonth()+3))+"-10");
        datas.push(d.getUTCFullYear()+"-"+(((d.getUTCMonth()+3)>12)?'01':(d.getUTCMonth()+3))+"-20");
    }

    z = "";

    var v = me_dia_vencimento.getAttribute("data-v");
    v = new Date(v);

    var selected;

    for(var i=0;i<datas.length;i++){
        y =  new Date(datas[i]);
        selected = (y.getTime()=== v.getTime())?'selected':"";
        z += "<option value='"+datas[i]+"' "+selected+">"+ y.getUTCDate()+"/"+ (y.getMonth()+1)+"/"+ y.getUTCFullYear()+"</option>";
    }
    me_dia_vencimento.innerHTML = z;
}
*/