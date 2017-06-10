import cv2
import sys
#from phpserialize import * #PHP'e data aktarirken bu modulu kullan.

imagePath = sys.argv[1]
cascPath = sys.argv[2]

faceCascade = cv2.CascadeClassifier(cascPath)
image = cv2.imread(imagePath)
gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

faces = faceCascade.detectMultiScale(
    gray,
    scaleFactor=1.1,
    minNeighbors=6,
    minSize=(30, 30),
    flags = cv2.cv.CV_HAAR_SCALE_IMAGE
)

#print "Found {0} faces!".format(len(faces))

array = []
for (x, y, w, h) in faces:
    #_str = x,y,w,h
    array.append(x)
    array.append(y)
    array.append(w)
    array.append(h)
    #cv2.rectangle(image, (x, y), (x+w, y+h), (255, 255, 255), 1)
print array
#print dict_to_tuple(loads(dumps((print for i in array))))

#cv2.imshow("Faces found", image)
#cv2.waitKey(0)
