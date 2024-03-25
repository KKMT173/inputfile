import zipfile
import fitz
from PyPDF2 import PdfReader, PdfWriter
from django.http import HttpResponse
from django.shortcuts import render
from django.db import connections
import os

def split_pdf(pdf_path, pdf_filename):
    pdf = PdfReader(pdf_path)
    num_pages = len(pdf.pages)

    with connections['default'].cursor() as cursor:
        cursor.execute("INSERT INTO pdf_files (file_path) VALUES (%s) RETURNING id", (pdf_path,))
        pdf_id = cursor.fetchone()[0]  # Use index [0] to get the first value from the tuple
        
        for page_num in range(num_pages):
            output = PdfWriter()
            output.add_page(pdf.pages[page_num])

            page_file_name = f"{os.path.splitext(pdf_filename)[0]}_page_{page_num + 1}.pdf"  # Use the uploaded PDF filename as the base name
            
            # Write the page to a new PDF file
            with open(os.path.join(os.path.dirname(pdf_path), page_file_name), 'wb') as output_pdf:
                output.write(output_pdf)

            # Insert information about the page into the database
            cursor.execute("INSERT INTO pdf_pages (pdf_id, page_number, file_path) VALUES (%s, %s, %s)", (pdf_id, page_num + 1, page_file_name))

        connections['default'].commit()

def extract_and_split_zip(zip_file):
    with zipfile.ZipFile(zip_file, 'r') as zip_ref:
        # Extract the contents of the ZIP file to a temporary folder
        extracted_folder = os.path.join(os.getcwd(), 'extracted_files')
        zip_ref.extractall(extracted_folder)

        # Iterate over the extracted files
        for root, _, files in os.walk(extracted_folder):
            for file in files:
                if file.endswith('.pdf'):
                    pdf_path = os.path.join(root, file)
                    split_pdf(pdf_path, file)


def upload_pdf(request):
    if request.method == 'POST':
        zip_file = request.FILES['zip_file']
        # Define the path of the ZIP file
        zip_path = os.path.join(os.getcwd(), 'pdf_files', zip_file.name)
        # Save the ZIP file to the server
        with open(zip_path, 'wb') as f:
            for chunk in zip_file.chunks():
                f.write(chunk)
        
        extract_and_split_zip(zip_path)
        return HttpResponse('ZIP file uploaded successfully!')
    else:
        return render(request, 'upload.html')
