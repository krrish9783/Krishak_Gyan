from flask import Flask, render_template, request
import joblib
import pandas as pd

app = Flask(__name__)

# Load the trained model
model = joblib.load('fertilizer_model.pkl')

# Load the dataset to extract unique values for Soil Type and Crop Type
data = pd.read_csv('fertilizers.csv')
soil_types = data['Soil Type'].unique()
crop_types = data['Crop Type'].unique()

# Create LabelEncoder instances for Soil Type and Crop Type
le_soilType = joblib.load('soilType_label_encoder.pkl')
le_cropType = joblib.load('cropType_label_encoder.pkl')

@app.route('/')
def home():
    return render_template('index.html', crop_types=crop_types)

@app.route('/recommend', methods=['POST'])
def recommend():
    temperature = float(request.form['temperature'])
    humidity = float(request.form['humidity'])
    soilMoisture = float(request.form['soilMoisture'])
    soilType = request.form['soilType']
    cropType = request.form['cropType']
    nitrogen = float(request.form['nitrogen'])
    potassium = float(request.form['potassium'])
    phosphorous = float(request.form['phosphorous'])

    # Encode soilType and cropType using the loaded LabelEncoders
    soilType_encoded = le_soilType.transform([soilType])
    cropType_encoded = le_cropType.transform([cropType])

    # You need to include all 8 features in the input data
    input_data = [[temperature, humidity, soilMoisture, soilType_encoded[0], cropType_encoded[0], nitrogen, potassium, phosphorous]]
    fertilizer_name = model.predict(input_data)[0]

    return render_template('result.html', fertilizer=fertilizer_name)

if __name__ == '__main__':
    app.run(debug=True)

