import fitz  # PyMuPDF

def extract_text_and_positions(pdf_path):
    doc = fitz.open(pdf_path)
    text_and_positions = []

    for page in doc:
        blocks = page.get_text("dict")["blocks"]
        for b in blocks:  # วนลูปผ่านบล็อกข้อความในแต่ละหน้า
            lines = b.get("lines", [])  # ตรวจสอบคีย์ 'lines' ในบล็อก
            for l in lines:  # วนลูปผ่านบรรทัดข้อความในบล็อก
                for s in l["spans"]:  # วนลูปผ่านส่วนของข้อความในแต่ละบรรทัด
                    text = s["text"]
                    bbox = s["bbox"]  # ตำแหน่งของข้อความ (x0, y0, x1, y1)
                    text_and_positions.append((text, bbox))

    return text_and_positions

# เรียกใช้ฟังก์ชันเพื่อดึงข้อความและตำแหน่งจากไฟล์ PDF
pdf_path = "C:\\Users\\User\\Desktop\\inputfile\\pdf_files\\page_1.pdf"  # แทนที่ด้วยตำแหน่งและชื่อไฟล์ PDF ของคุณ
text_and_positions = extract_text_and_positions(pdf_path)

# พิมพ์ข้อความและตำแหน่งที่ได้
for text, bbox in text_and_positions:
    print(f"Text: {text}, Position: {bbox}")
