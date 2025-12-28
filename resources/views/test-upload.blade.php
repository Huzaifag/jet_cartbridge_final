<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Video Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Test Video Upload</h4>
                    </div>
                    <div class="card-body">
                        <form id="testForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="testMedia" class="form-label">Upload Test Files</label>
                                <input class="form-control" type="file" name="media[]" id="testMedia"
                                    accept="image/*,video/mp4,video/mov,video/avi,video/webm" multiple>
                                <div class="form-text">
                                    <small class="text-muted">Test file upload functionality</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="testBtn">Test Upload</button>
                        </form>
                        
                        <div id="results" class="mt-4" style="display: none;">
                            <h5>Results:</h5>
                            <pre id="resultData" class="bg-light p-3 rounded"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('testForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const testBtn = document.getElementById('testBtn');
            const results = document.getElementById('results');
            const resultData = document.getElementById('resultData');
            
            testBtn.disabled = true;
            testBtn.innerHTML = 'Testing...';
            
            fetch('/test-upload', {
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
                testBtn.disabled = false;
                testBtn.innerHTML = 'Test Upload';
            });
        });
    </script>
</body>
</html>