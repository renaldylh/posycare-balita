<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeWithML extends Command
{
    protected $signature = 'serve:ml {--host=127.0.0.1} {--port=8000}';
    protected $description = 'Start Laravel development server with ML Python API';

    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        
        $pythonPath = base_path('python_api');
        $batchFile = $pythonPath . DIRECTORY_SEPARATOR . 'start_flask.bat';
        
        $this->info('🚀 Starting POSYCARE with ML Support...');
        $this->newLine();
        
        // Check if Flask is already running
        if ($this->checkFlaskApi()) {
            $this->info('✅ ML API already running at http://localhost:5000');
        } else {
            $this->info('📊 Starting ML Prediction API (Flask)...');
            
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows: Use start command with batch file
                $cmd = 'start "Flask_ML_API" /MIN cmd /c "' . $batchFile . '"';
                exec($cmd);
            } else {
                // Linux/Mac
                $pythonScript = $pythonPath . '/predict_api.py';
                exec('nohup python3 "' . $pythonScript . '" > /dev/null 2>&1 &');
            }
            
            // Wait for Flask to start
            $this->output->write('   Waiting');
            $flaskRunning = false;
            for ($i = 0; $i < 10; $i++) {
                sleep(1);
                $this->output->write('.');
                if ($this->checkFlaskApi()) {
                    $flaskRunning = true;
                    break;
                }
            }
            $this->newLine();
            
            if ($flaskRunning) {
                $this->info('✅ ML API running at http://localhost:5000');
            } else {
                $this->warn('⚠️  ML API may be starting slowly or failed.');
                $this->warn('   If predictions fail, run in separate terminal:');
                $this->warn('   cd python_api && python predict_api.py');
            }
        }
        
        $this->newLine();
        $this->info('🌐 Starting Laravel development server...');
        $this->info("   App:     http://{$host}:{$port}");
        $this->info("   Predict: http://{$host}:{$port}/predict");
        $this->info("   ML API:  http://localhost:5000");
        $this->newLine();
        $this->info('Press Ctrl+C to stop Laravel server.');
        $this->warn('Note: Flask API runs in separate window - close it manually.');
        $this->newLine();
        
        $this->call('serve', ['--host' => $host, '--port' => $port]);
        
        return 0;
    }
    
    private function checkFlaskApi(): bool
    {
        try {
            $ch = curl_init('http://localhost:5000/health');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $httpCode === 200 && str_contains($response, 'ok');
        } catch (\Exception $e) {
            return false;
        }
    }
}
