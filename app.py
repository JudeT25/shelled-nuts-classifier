import sys
import os
from flask import Flask, request, jsonify, render_template, flash
from torch_utils import get_prediction

app = Flask(__name__)

result = 'huh'

def helper_func(data):
    return render_template('result.html', result=data)

ALLOWED_EXTENSIONS = {'jpg'}
def allowed_file(filename):
    #function checks the extension of the file. has to be jpg
    return '.' in filename and filename.rsplit('.',1)[1].lower() in ALLOWED_EXTENSIONS
app.secret_key = "eiuweuy_wbnd628_wh70"

@app.route('/')
def index():
    return render_template('form.html')

@app.route('/upload', methods=['POST'])
def upload():
    file = request.files['image']
    if file:
        # Save the file to a directory
        file.save('newData/image.jpg')
        return render_template('uploadsuccess.html')
    else:
        return 'No file uploaded'

@app.route('/predict', methods=['POST', 'GET'])
def predict(): 
    data = get_prediction()

    return render_template('result.html', result=data)
    
        #except:
           # return jsonify({'error': 'error during prediction'})