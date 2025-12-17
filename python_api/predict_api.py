"""
Flask API untuk Prediksi Status Gizi Balita
Menggunakan model Random Forest yang sudah ditraining
"""

from flask import Flask, request, jsonify
from flask_cors import CORS
import joblib
import numpy as np
import os

app = Flask(__name__)
CORS(app)  # Enable CORS for Laravel to call this API

# Load the trained model
MODEL_PATH = os.path.join(os.path.dirname(__file__), '..', 'storage', 'app', 'models', 'status_gizi_model.joblib')
model = None

def load_model():
    global model
    if model is None:
        model = joblib.load(MODEL_PATH)
        print(f"Model loaded successfully from {MODEL_PATH}")
    return model

@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({
        'status': 'ok',
        'message': 'ML Prediction API is running'
    })

@app.route('/predict', methods=['POST'])
def predict():
    """
    Predict status gizi based on input features
    
    Expected JSON input:
    {
        "usia_bulan": 12,      # Age in months (0-60)
        "jenis_kelamin": "L",  # L=Laki-laki, P=Perempuan
        "berat_badan": 9.0,    # Weight in kg
        "tinggi_badan": 73.0,  # Height in cm
        "lingkar_kepala": 45.0,# Head circumference in cm
        "lila": 15.0           # Upper arm circumference in cm
    }
    
    Returns:
    {
        "success": true,
        "status_gizi": "Gizi Normal",
        "probability": {"Gizi Normal": 0.95, "Gizi Buruk": 0.05}
    }
    """
    try:
        data = request.get_json()
        
        if not data:
            return jsonify({
                'success': False,
                'error': 'No input data provided'
            }), 400
        
        # Extract and validate features
        required_fields = ['usia_bulan', 'jenis_kelamin', 'berat_badan', 'tinggi_badan', 'lingkar_kepala', 'lila']
        for field in required_fields:
            if field not in data:
                return jsonify({
                    'success': False,
                    'error': f'Missing required field: {field}'
                }), 400
        
        # Prepare features for model
        # Model expects: ['usia', 'jk', 'bb', 'tb', 'lila', 'lk']
        usia = float(data['usia_bulan'])
        jk = 1 if data['jenis_kelamin'] == 'L' else 0  # L=1, P=0
        bb = float(data['berat_badan'])
        tb = float(data['tinggi_badan'])
        lila = float(data['lila'])
        lk = float(data['lingkar_kepala'])
        
        # Create feature array
        features = np.array([[usia, jk, bb, tb, lila, lk]])
        
        # Load model and predict
        clf = load_model()
        prediction = clf.predict(features)[0]
        probabilities = clf.predict_proba(features)[0]
        
        # Create probability dict
        prob_dict = {}
        for i, cls in enumerate(clf.classes_):
            prob_dict[cls] = round(float(probabilities[i]), 4)
        
        # Calculate BMI for additional info
        tb_m = tb / 100
        bmi = bb / (tb_m * tb_m) if tb_m > 0 else 0
        
        return jsonify({
            'success': True,
            'status_gizi': prediction,
            'probability': prob_dict,
            'bmi': round(bmi, 2),
            'input_summary': {
                'usia_bulan': usia,
                'jenis_kelamin': data['jenis_kelamin'],
                'berat_badan': bb,
                'tinggi_badan': tb,
                'lingkar_kepala': lk,
                'lila': lila
            }
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

@app.route('/model-info', methods=['GET'])
def model_info():
    """Get information about the loaded model"""
    try:
        clf = load_model()
        return jsonify({
            'success': True,
            'model_type': type(clf).__name__,
            'classes': clf.classes_.tolist(),
            'n_features': clf.n_features_in_,
            'feature_names': ['usia', 'jk', 'bb', 'tb', 'lila', 'lk'],
            'feature_importances': dict(zip(
                ['usia', 'jk', 'bb', 'tb', 'lila', 'lk'],
                [round(float(x), 4) for x in clf.feature_importances_]
            ))
        })
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

if __name__ == '__main__':
    import sys
    import os
    
    # Pre-load model
    load_model()
    
    # Check if running in background (no TTY)
    # Disable debug mode if stdout is not a terminal (background mode)
    is_tty = sys.stdout.isatty() if hasattr(sys.stdout, 'isatty') else False
    debug_mode = is_tty
    
    # Suppress Flask banner in background mode to avoid stdout errors
    if not is_tty:
        import logging
        log = logging.getLogger('werkzeug')
        log.setLevel(logging.ERROR)
        # Redirect stdout/stderr to devnull in background
        sys.stdout = open(os.devnull, 'w')
        sys.stderr = open(os.devnull, 'w')
    else:
        print("Starting ML Prediction API on http://localhost:5000")
    
    # Run Flask app
    app.run(host='0.0.0.0', port=5000, debug=debug_mode, use_reloader=debug_mode)
