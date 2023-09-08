import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import accuracy_score

# Load your dataset (replace 'your_dataset.csv' with the actual file path)
data = pd.read_csv('state.csv')

# Encode categorical features
label_encoder = LabelEncoder()
data['State_Name'] = label_encoder.fit_transform(data['State_Name'])
data['District_Name'] = label_encoder.fit_transform(data['District_Name'])
data['Season'] = label_encoder.fit_transform(data['Season'])

# Split data into training and testing sets
X = data[['State_Name', 'District_Name', 'Season']]
y = data['Crop']
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Create and train a Random Forest Classifier model
random_forest_model = RandomForestClassifier(n_estimators=100, random_state=42)
random_forest_model.fit(X_train, y_train)

# Make predictions on the test set
y_pred = random_forest_model.predict(X_test)

# Calculate accuracy
accuracy = accuracy_score(y_test, y_pred)
print(f'Accuracy: {accuracy}')
