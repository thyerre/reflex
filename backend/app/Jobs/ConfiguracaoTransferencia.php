<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConfiguracaoTransferencia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private  $id_data_warehouse;

    public function __construct($id)
    {
        $this->id_data_warehouse = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $configuracao = \App\Configuracao::find($this->id_data_warehouse);
        
        if (!$configuracao) {
            return false;
        }

        $dataWarehouse = \App\DataWarehouse::find($this->id_data_warehouse);
        $configuracaoTransferencia = \App\ConfiguracaoTransferencia::pegarTranferencia($this->id_data_warehouse);

        if (!$configuracaoTransferencia) {
            \App\ConfiguracaoTransferencia::criarTranferencia($configuracao, $dataWarehouse);//Criar uma tranferencia
            $configuracaoTransferencia = \App\ConfiguracaoTransferencia::pegarTranferencia($this->id_data_warehouse);
        }

        if (!$configuracaoTransferencia) {
            return false;
        }

        if ($configuracaoTransferencia->bo_ativo) {
            $dados = \App\ConfiguracaoTransferencia::continuarTranferencia($configuracao, $dataWarehouse);// Continuar uma transferencia
            \App\ConfiguracaoTransferencia::finalizarTranferencia($dados, $dataWarehouse, $configuracao);// Finalizar uma transferencia
        }

    }

    public function failed()
    {
        // Called when the job is failing...
    }
}
