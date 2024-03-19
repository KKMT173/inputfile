from django.http import HttpResponse
from django.shortcuts import render
from django.db import connections
from PyPDF2 import PdfReader, PdfWriter
import os


def split_pdf(pdf_path):
    pdf = PdfReader(pdf_path)
    num_pages = len(pdf.pages)

    with connections['default'].cursor() as cursor:
        cursor.execute("INSERT INTO pdf_files (file_path) VALUES (%s) RETURNING id", (pdf_path,))
        pdf_id = cursor.fetchone()[0]

        for page_num in range(num_pages):
            output = PdfWriter()
            output.add_page(pdf.pages[page_num])
            page_file_path = f"page_{page_num + 1}.pdf"
            with open(os.path.join(os.path.dirname(pdf_path), page_file_path), 'wb') as output_pdf:
                output.write(output_pdf)
            cursor.execute("INSERT INTO pdf_pages (pdf_id, page_number, file_path) VALUES (%s, %s, %s)", (pdf_id, page_num + 1, page_file_path))

        connections['default'].commit()

def upload_pdf(request):
    if request.method == 'POST':
        pdf_file = request.FILES['pdf_file']
        # กำหนด path ของไฟล์ PDF
        pdf_path = os.path.join(os.getcwd(), 'pdf_files', pdf_file.name)
        # บันทึกไฟล์ PDF ลงในเซิร์ฟเวอร์
        with open(pdf_path, 'wb') as f:
            for chunk in pdf_file.chunks():
                f.write(chunk)
        
        split_pdf(pdf_path)  # แก้ path ให้เป็น './pdf_project/pdf_files/{pdf_file.name}'
        return HttpResponse('PDF uploaded successfully!')
    else:
        return render(request, 'upload.html')
