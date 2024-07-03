import cv2 
from flask import Flask, jsonify, render_template, Response
from flask_cors import CORS 
import torch 
from flask_socketio import SocketIO, emit 
  
app = Flask(__name__) 
CORS(app, resources={r"/*": {"origins": "*"}})
socketio = SocketIO(app, cors_allowed_origins="*")  # Initialize SocketIO with the app

camera_running = False # Add this line at the beginning of your app.py

def load_yolov5_model(weights_path): 
    model = torch.hub.load('ultralytics/yolov5', 'custom', path=weights_path, force_reload=True) 
    model.conf = 0.3
    return model 
 
 
detected_objects = []  # Modify this line at the beginning of your app.py
  
def generate_frames(model):
    global detected_objects
    cap = None
    class_names = model.module.names if hasattr(model, 'module') else model.names

    while True:
        if camera_running:
            if cap is None:
                cap = cv2.VideoCapture(0)
            ret, frame = cap.read()

            if not ret:
                break

            results = model(frame)

            detected_objects = []  # Add this line

            for *xyxy, conf, cls in results.xyxy[0]:
                cv2.rectangle(frame, (int(xyxy[0]), int(xyxy[1])), (int(xyxy[2]), int(xyxy[3])), (255, 0, 0), 2)
                label = f"{class_names[int(cls)]}: {conf:.2f}"
                cv2.putText(frame, label, (int(xyxy[0]), int(xyxy[1]) - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (255, 0, 0), 2)
                
                detected_objects.append(class_names[int(cls)])  # Modify this line

            socketio.emit('update_objects', detected_objects)

            ret, buffer = cv2.imencode('.jpg', frame)
            frame = buffer.tobytes()

            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')
        else:
            if cap is not None:
                cap.release()
                cap = None
            detected_objects = []  # Add this line
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + b'' + b'\r\n')



@app.route('/video_feed')
def video_feed():
    model = load_yolov5_model('drinks.pt')
    return Response(generate_frames(model), content_type='multipart/x-mixed-replace; boundary=frame')

@app.route('/detected_objects')
def get_detected_objects():
    return jsonify(detected_objects)

@socketio.on('start_camera') # Add this line to handle the 'start_camera' message
def handle_start_camera():
    global camera_running
    camera_running = True

@socketio.on('stop_camera')
def handle_stop_camera():
    global camera_running
    print("Stopping camera...")
    camera_running = False


if __name__ == '__main__': 
    app.run(host="0.0.0.0", port=5050)

