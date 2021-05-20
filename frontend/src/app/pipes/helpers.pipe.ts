import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
    name: 'helpers'
})
export class HelpersPipe implements PipeTransform {

    transform(value: any, args?: any, args1?: any): any {
        return this.oquefazer(value, args, args1);
    }

    oquefazer(value: string, args: string, args1: string) {
        let texto = '';
        switch (args) {
            case 'zeroEsquerda': {
                return this.zeroEsquerda(value, args1);
                break;
            }
            case 'tp_fisicajuridica': {
                return this.tp_fisicajuridica(value, args1);
                break;
            }
            case 'tp_cadastro': {
                return this.tp_cadastro(value, args1);
                break;
            }
            case 'getFileExtension': {
                return this.getFileExtension(value, args1);
                break;
            }
            case 'iconorder': {
                return this.iconorder(value, args1);
                break;
            }
            case 'pedidoAceitoRecusado': {
                return this.pedidoAceitoRecusado(value, args1);
                break;
            }
            case 'ifTimeIsNull': {
                return this.ifTimeIsNull(value, args1);
                break;
            }
            case 'CaixaAbertoFechado': {
                return this.CaixaAbertoFechado(value);
                break;
            }
            case 'caixaIsMy': {
                return this.caixaIsMy(value, args1);
                break;
            }
            case 'checkVencimento': {
                return this.checkVencimento(value, args1);
                break;
            }
            default: {
                break;
            }
        }
        return texto;
    }
    caixaIsMy(id, args) {
        let myCaixa = localStorage.getItem('caixa');
        if (myCaixa == id) {
            if (args == 'label') {
                return 'Sim'
            } else {
                return 'caixaUsing'
            }
        }
        if (args == 'label')
            return 'Não'


    }

    CaixaAbertoFechado(id_caixa_tipo) {
        if (id_caixa_tipo == 5) {
            return "<div class='label label-table label-success piscando'>Aberto</div>";
        } else if (id_caixa_tipo == 6) {
            return "<div class='label label-table label-danger'>Fechado</div>";
        } else {
            return "";
        }
    }
    zeroEsquerda(value, palavra) {
        var casasDecimais = value.toString().length;
        var zeros = '';
        if (casasDecimais <= 4) {
            let quantidadeFaltando = (4 - casasDecimais);
            for (let index = 0; index < quantidadeFaltando; index++) {
                zeros += '0';
            }
        }
        return zeros + value;
    }
    pedidoAceitoRecusado(value, palavra) {
        // console.log(value);
        if (value.ts_pedido_aceitorecusado) {
            if (value.bo_aceito) {
                return 'statusPedido-aceito-cor';
            }
            return 'statusPedido-recusado-cor';
        }
    }
    checkVencimento(value, palavra) {
        var UserDate = value;
        if (value.length == 10) {
            UserDate = value + ' 23:59:59';
        }
        var ToDate = new Date();

        var retorno = null;
        if (new Date(UserDate).getTime() < ToDate.getTime()) {
            retorno = "<div class='label label-table label-danger'>Vencido</div>";
        }
        return retorno
    }
    ifTimeIsNull(value, palavra) {
        if (value) {
            return value;
        }
        return '--:--';
    }
    tp_fisicajuridica(value, palavra) {
        if (value == 'fisica') {
            return 'Pessoa fisica';
        }
        return 'Pessoa juridica';
    }
    tp_cadastro(value, palavra) {
        if (value == 1) {
            return "Cliente";
        }
        return "Fornecedor";
    }
    getFileExtension(value, palavra) {
        if (value) {
            return value.split('.').pop() + ".svg";
        }
        return "file.svg";
    }
    iconorder(value, palavra) {
        return value == '' ? 'fas fa-sort' : value == 'desc' ? 'fas fa-sort-down' : 'fas fa-sort-up';
    }
}
