<?php

namespace App\Lib;

class StartFlaskPython {

    public function executar() {
        $pid = shell_exec('cd /var/www/physionet/public_html/python/;python3 api_monitor_sinais.py >> /dev/null 2>&1 & echo $!;');
        sleep(8);
    }

    public function reiniciar() {
        exec('pkill -f api_monitor_sinais.py');
        sleep(3);
        $pid = shell_exec('cd /var/www/physionet/public_html/python/;python3 api_monitor_sinais.py >> /dev/null 2>&1 & echo $!;');
        sleep(8);
    }

}
