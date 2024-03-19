from django.urls import path
from . import views  # นำเข้าโมดูล views ที่เราใช้

urlpatterns = [
    path('upload_pdf/', views.upload_pdf, name='upload_pdf'),
    # เพิ่ม URL pattern เพื่อเชื่อมโยงไปยังฟังก์ชัน upload_pdf ใน views.py
]
