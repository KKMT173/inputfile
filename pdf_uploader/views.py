import fitz
from PyPDF2 import PdfReader, PdfWriter
from django.http import HttpResponse
from django.shortcuts import render
from django.db import connections
import os

def extract_text_from_position(pdf_path, needle):
    doc = fitz.open(pdf_path)
    extracted_text = ""
    for page in doc:
        text_instances = page.search_for(needle)  # Search for the specified text
        for rect in text_instances:
            text = page.get_text("text", clip=rect)
            extracted_text += text.strip() + " "  # Add a space after each extracted text
    return extracted_text.strip()


def split_pdf(pdf_path):
    pdf = PdfReader(pdf_path)
    num_pages = len(pdf.pages)

    with connections['default'].cursor() as cursor:
        cursor.execute("INSERT INTO pdf_files (file_path) VALUES (%s) RETURNING id", (pdf_path,))
        pdf_id = cursor.fetchone()[0]  # Use index [0] to get the first value from the tuple
        print("PDF ID:", pdf_id)  # Print the PDF ID for debugging purposes
        
        needle = "FILM"  # Define the search text
        
        for page_num in range(num_pages):
            output = PdfWriter()
            output.add_page(pdf.pages[page_num])
            
            # Define the filename for each page using the search text
            page_file_name = f"{needle}_page_{page_num + 1}.pdf"

            # Write the page to a new PDF file
            with open(os.path.join(os.path.dirname(pdf_path), page_file_name), 'wb') as output_pdf:
                output.write(output_pdf)

            # Insert information about the page into the database
            cursor.execute("INSERT INTO pdf_pages (pdf_id, page_number, file_path) VALUES (%s, %s, %s)", (pdf_id, page_num + 1, page_file_name))

        connections['default'].commit()


def upload_pdf(request):
    if request.method == 'POST':
        pdf_file = request.FILES['pdf_file']
        # Define the path of the PDF file
        pdf_path = os.path.join(os.getcwd(), 'pdf_files', pdf_file.name)
        # Save the PDF file to the server
        with open(pdf_path, 'wb') as f:
            for chunk in pdf_file.chunks():
                f.write(chunk)
        
        split_pdf(pdf_path)  # Adjust the path to './pdf_project/pdf_files/{pdf_file.name}'
        return HttpResponse('PDF uploaded successfully!')
    else:
        return render(request, 'upload.html')
