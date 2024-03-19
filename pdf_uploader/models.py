from django.db import models

class PDFFile(models.Model):
    file = models.FileField(upload_to='pdf_files/')
    uploaded_at = models.DateField(auto_now_add=True)

    def get_absolute_url(self):
        return reverse("_detail", kwargs={"pk": self.pk})

    class Meta:
        app_label = 'pdf_uploader'
