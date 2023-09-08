import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
import joblib

# Load the preprocessed data
data_path = '/home/krishna/Documents/Ready/crop_input/Crop_recommendation.csv'
data = pd.read_csv(data_path)

# Separate features (X) and target labels (y)
X = data.drop('label', axis=1)
y = data['label']

# Split the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Initialize and train the Random Forest model
rf_model = RandomForestClassifier(n_estimators=100, random_state=42)
rf_model.fit(X_train, y_train)

# Save the trained model to a file
joblib.dump(rf_model, 'trained_model.joblib')

print("Trained model saved as trained_model.joblib")

