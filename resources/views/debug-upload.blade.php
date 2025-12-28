<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Debug Video Review Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4>Debug Video Review Upload</h4>
                        <p class="mb-0 text-muted">Test the exact same form as the product review modal</p>
                    </div>
                    <div class="card-body">
                        <form id="debugForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select class="form-select" name="rating" id="rating" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="reviewType" class="form-label">Review Type</label>
                                <select class="form-select" name="review_type" id="reviewType" required>
                                    <option value="text">Text Only</option>
                                    <option value="text_image">Text + Images</option>
                                    <option value="video">Short Video Review (Earn Coins! 💰)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="reviewText" class="form-label">Review Text</label>
                                <textarea class="form-control" name="review_text" id="reviewText" rows="3" 
                                    placeholder="Share your experience...">Test video review</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="debugMedia" class="form-label">Upload Media (Images / Video)</label>
                                <input class="form-control" type="file" name="media[]" id="debugMedia"
                                    accept="image/*,video/mp4,video/mov,video/avi,video/webm" multiple>
                                <div class="form-text">
                                    <small class="text-muted">Test file upload functionality</small>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" id="debugBtn">Debug Upload</button>
                        </form>
                        
                        <div id="results" class="mt-4" style="display: none;">
                            <h5>Debug Results:</h5>
                            <pre id="resultData" class="bg-light p-3 rounded" style="max-height: 500px; overflow-y: auto;"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('debugForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const debugBtn = document.getElementById('debugBtn');
            const results = document.getElementById('results');
            const resultData = document.getElementById('resultData');
            
            debugBtn.disabled = true;
            debugBtn.innerHTML = 'Debugging...';
            
            fetch('/debug-review-upload', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                results.style.display = 'block';
                resultData.textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                results.style.display = 'block';
                resultData.textContent = 'Error: ' + error.message;
            })
            .finally(() => {
                debugBtn.disabled = false;
                debugBtn.innerHTML = 'Debug Upload';
            });
        });
        
        // Auto-select video review type for testing
        document.getElementById('reviewType').value = 'video';
        document.getElementById('rating').value = '5';
    </script>
</body>
</html>