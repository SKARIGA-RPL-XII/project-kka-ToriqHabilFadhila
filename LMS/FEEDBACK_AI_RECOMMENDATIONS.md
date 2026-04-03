# Feedback AI Recommendations System

## Masalah yang Diperbaiki

### 1. Jawaban Berbeda Setiap Refresh
**Penyebab**: `getRecommendations()` memanggil `$this->ai->recommendMaterials()` setiap kali, yang generate rekomendasi baru secara random.

**Solusi**: 
- Sistem sekarang mengambil rekomendasi dari database `feedback_ai` terlebih dahulu
- Jika ada feedback yang tersimpan, gunakan itu (konsisten)
- Hanya generate baru jika tidak ada feedback di database

### 2. Tidak Ada Link untuk Mengakses Materi
**Penyebab**: Rekomendasi hanya berupa teks tanpa link ke materi pembelajaran.

**Solusi**:
- Backend (`AIController.formatRecommendationsWithLinks()`) mencari nama materi dalam rekomendasi
- Otomatis menambahkan link HTML ke halaman materi (`/siswa/materials`)
- Frontend menampilkan link yang dapat diklik

## Alur Kerja

### Saat Guru Menganalisis Siswa
1. Guru klik "Analisis Performa" di dashboard
2. `AIController.analyzeProgress()` dipanggil
3. `FeedbackAIService.generateAndSaveFeedback()` menyimpan ke database:
   - `feedback_text`: Profil siswa (mata pelajaran, nilai, progress, dll)
   - `rekomendasi_materi`: Rekomendasi materi pembelajaran
   - `saran`: Saran untuk improvement

### Saat Siswa Membuka Rekomendasi
1. Siswa buka halaman "Rekomendasi Materi"
2. Frontend fetch ke `/siswa/ai/recommendations`
3. Backend `AIController.getRecommendations()`:
   - Cek apakah ada feedback di database
   - Jika ada: Parse dan format dengan link ke materi
   - Jika tidak ada: Generate baru (fallback)
4. Frontend menampilkan profil + rekomendasi dengan link

## Database Schema

### feedback_ai table
```
- id_feedback (PK)
- id_submission (FK)
- feedback_text (text) - Profil siswa
- saran (text) - Saran improvement
- rekomendasi_materi (text) - Rekomendasi materi
- created_at (timestamp)
```

## Contoh Response

```json
{
  "success": true,
  "profile": {
    "subject": "Matematika",
    "last_scores": "85, 90, 78",
    "avg_score": 84.3,
    "progress": "3 dari 5 tugas",
    "performance_status": "Baik",
    "weak_topics": "Trigonometri",
    "available_materials": "Materi Trigonometri (Matematika)"
  },
  "recommendations": "<br>1. Materi Trigonometri<br>   Pelajari konsep dasar trigonometri...<br>   <a href='/siswa/materials'>Materi Trigonometri</a><br>",
  "from_database": true
}
```

## Keuntungan

✅ **Konsistensi**: Rekomendasi sama setiap kali dibuka (dari database)
✅ **Navigasi Mudah**: Link langsung ke materi pembelajaran
✅ **Tracking**: Guru bisa lihat kapan feedback dibuat
✅ **Fallback**: Jika belum ada feedback, generate otomatis
