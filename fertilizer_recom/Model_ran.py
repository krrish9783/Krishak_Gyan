import pandas as pd
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
import joblib

# Load the CSV data
data = pd.read_csv('fertilizers.csv')

# Encode categorical variables (Soil Type and Crop Type)
le_soilType = LabelEncoder()
data['Soil Type'] = le_soilType.fit_transform(data['Soil Type'])
joblib.dump(le_soilType, 'soilType_label_encoder.pkl')  # Save the Soil Type encoder

le_cropType = LabelEncoder()
data['Crop Type'] = le_cropType.fit_transform(data['Crop Type'])
joblib.dump(le_cropType, 'cropType_label_encoder.pkl')  # Save the Crop Type encoder

# Split the data into features and target
X = data.drop('Fertilizer Name', axis=1)
y = data['Fertilizer Name']

# Split data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train a Random Forest Classifier
rf_model = RandomForestClassifier(n_estimators=100, random_state=42)
rf_model.fit(X_train, y_train)

# Evaluate the model on the test set (optional)
accuracy = rf_model.score(X_test, y_test)
print(f"Model Accuracy: {accuracy}")

# Save the trained model to a file for later use
joblib.dump(rf_model, 'fertilizer_model.pkl')

