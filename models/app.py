from flask import Flask, render_template, request
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
import joblib

app = Flask(__name__)

# Load the trained model
model = joblib.load('trained_model.joblib')

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        N = float(request.form['N'])
        P = float(request.form['P'])
        K = float(request.form['K'])
        temperature = float(request.form['temperature'])
        humidity = float(request.form['humidity'])
        pH = float(request.form['pH'])
        rainfall = float(request.form['rainfall'])

        # Make a prediction using the model
        prediction = model.predict([[N, P, K, temperature, humidity, pH, rainfall]])
        
        return render_template('index.html', prediction=prediction[0])

    return render_template('index.html', prediction=None)

if __name__ == '__main__':
    app.run(debug=True)

