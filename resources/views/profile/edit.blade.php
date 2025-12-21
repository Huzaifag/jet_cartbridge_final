@extends('frontend.layout.main')

@push('styles')
<style>
/* LinkedIn-style Profile Edit Styles */
.linkedin-profile-edit {
    background: #f3f2ef;
    min-height: 100vh;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    padding: 24px 0;
}

.edit-header {
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 0 1px rgba(0,0,0,.15), 0 2px 3px rgba(0,0,0,.2);
    margin-bottom: 16px;
    padding: 24px;
}

.edit-title {
    font-size: 24px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin: 0 0 8px 0;
}

.edit-subtitle {
    font-size: 14px;
    color: rgba(0,0,0,.6);
    margin: 0;
}

.edit-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 0 1px rgba(0,0,0,.15), 0 2px 3px rgba(0,0,0,.2);
    margin-bottom: 16px;
    overflow: hidden;
}

.section-header {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(0,0,0,.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin: 0;
}

.section-body {
    padding: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin-bottom: 8px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid rgba(0,0,0,.3);
    border-radius: 4px;
    font-size: 16px;
    color: rgba(0,0,0,.9);
    background: white;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #0a66c2;
    box-shadow: 0 0 0 2px rgba(10, 102, 194, 0.2);
}

.form-control::placeholder {
    color: rgba(0,0,0,.6);
}

.form-select {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid rgba(0,0,0,.3);
    border-radius: 4px;
    font-size: 16px;
    color: rgba(0,0,0,.9);
    background: white;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-select:focus {
    outline: none;
    border-color: #0a66c2;
    box-shadow: 0 0 0 2px rgba(10, 102, 194, 0.2);
}

.form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.form-check-input {
    width: 18px;
    height: 18px;
    border: 2px solid rgba(0,0,0,.3);
    border-radius: 3px;
    background: white;
}

.form-check-input:checked {
    background: #0a66c2;
    border-color: #0a66c2;
}

.form-check-label {
    font-size: 14px;
    color: rgba(0,0,0,.9);
    cursor: pointer;
}

.btn-linkedin-primary {
    background: #0a66c2;
    color: white;
    border: 1px solid #0a66c2;
    border-radius: 24px;
    padding: 8px 24px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.2s;
    cursor: pointer;
}

.btn-linkedin-primary:hover {
    background: #004182;
    border-color: #004182;
    color: white;
}

.btn-linkedin-secondary {
    background: transparent;
    color: #0a66c2;
    border: 1px solid #0a66c2;
    border-radius: 24px;
    padding: 8px 24px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.2s;
    cursor: pointer;
    text-decoration: none;
}

.btn-linkedin-secondary:hover {
    background: rgba(112, 181, 249, 0.2);
    color: #0a66c2;
    text-decoration: none;
}

.profile-photo-section {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
}

.current-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #f3f2ef;
    flex-shrink: 0;
}

.current-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-controls {
    flex: 1;
}

.photo-controls h4 {
    font-size: 16px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin: 0 0 8px 0;
}

.photo-controls p {
    font-size: 14px;
    color: rgba(0,0,0,.6);
    margin: 0 0 16px 0;
}

.file-input-wrapper {
    position: relative;
    display: inline-block;
}

.file-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.skills-input-container {
    position: relative;
}

.skills-display {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
    min-height: 40px;
    padding: 8px;
    border: 1px solid rgba(0,0,0,.3);
    border-radius: 4px;
    background: white;
}

.skill-tag {
    background: rgba(0,0,0,.08);
    color: rgba(0,0,0,.9);
    padding: 4px 8px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
}

.skill-remove {
    background: none;
    border: none;
    color: rgba(0,0,0,.6);
    cursor: pointer;
    padding: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.skill-remove:hover {
    background: rgba(0,0,0,.1);
}

.social-links-container {
    border: 1px solid rgba(0,0,0,.3);
    border-radius: 4px;
    padding: 16px;
    background: #f8f9fa;
}

.social-link-item {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
    align-items: center;
}

.social-link-item:last-child {
    margin-bottom: 0;
}

.social-platform-select {
    width: 150px;
    flex-shrink: 0;
}

.social-url-input {
    flex: 1;
}

.remove-social-link {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 12px;
}

.add-social-link {
    background: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 12px;
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding: 20px 24px;
    border-top: 1px solid rgba(0,0,0,.08);
    background: #f8f9fa;
}

.alert {
    padding: 12px 16px;
    border-radius: 4px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 768px) {
    .linkedin-profile-edit {
        padding: 16px 0;
    }
    
    .profile-photo-section {
        flex-direction: column;
        text-align: center;
    }
    
    .social-link-item {
        flex-direction: column;
        gap: 8px;
    }
    
    .social-platform-select {
        width: 100%;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
<div class="linkedin-profile-edit">
    <div class="container-fluid" style="max-width: 800px;">
        <!-- Header -->
        <div class="edit-header">
            <h1 class="edit-title">Edit your profile</h1>
            <p class="edit-subtitle">Keep your profile up-to-date to help people discover you and your work.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Basic Information -->
        <div class="edit-section">
            <div class="section-header">
                <h2 class="section-title">Basic Information</h2>
            </div>
            <form action="{{ route('profile.update.basic') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First name *</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" 
                                       value="{{ old('first_name', $user->profile?->first_name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last name *</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" 
                                       value="{{ old('last_name', $user->profile?->last_name) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email address *</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" 
                                       value="{{ old('phone', $user->profile?->phone) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">Date of birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" 
                                       value="{{ old('date_of_birth', $user->profile?->date_of_birth?->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="">Select gender</option>
                            <option value="male" {{ old('gender', $user->profile?->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->profile?->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $user->profile?->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea id="bio" name="bio" class="form-control" rows="3" 
                                  placeholder="Write a short bio about yourself...">{{ old('bio', $user->profile?->bio) }}</textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('user.profile') }}" class="btn-linkedin-secondary">Cancel</a>
                    <button type="submit" class="btn-linkedin-primary">Save changes</button>
                </div>
            </form>
        </div>

        <!-- Professional Information -->
        <div class="edit-section">
            <div class="section-header">
                <h2 class="section-title">Professional Information</h2>
            </div>
            <form action="{{ route('profile.update.basic') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="section-body">
                    <div class="form-group">
                        <label for="job_title" class="form-label">Job title</label>
                        <input type="text" id="job_title" name="job_title" class="form-control" 
                               value="{{ old('job_title', $user->profile?->job_title) }}" 
                               placeholder="e.g. Senior Software Engineer">
                    </div>

                    <div class="form-group">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" id="company" name="company" class="form-control" 
                               value="{{ old('company', $user->profile?->company) }}" 
                               placeholder="e.g. Google">
                    </div>

                    <div class="form-group">
                        <label for="industry" class="form-label">Industry</label>
                        <input type="text" id="industry" name="industry" class="form-control" 
                               value="{{ old('industry', $user->profile?->industry) }}" 
                               placeholder="e.g. Technology">
                    </div>

                    <div class="form-group">
                        <label for="professional_summary" class="form-label">Professional summary</label>
                        <textarea id="professional_summary" name="professional_summary" class="form-control" rows="4" 
                                  placeholder="Describe your professional experience and expertise...">{{ old('professional_summary', $user->profile?->professional_summary) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" id="website" name="website" class="form-control" 
                               value="{{ old('website', $user->profile?->website) }}" 
                               placeholder="https://yourwebsite.com">
                    </div>

                    <div class="form-group">
                        <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                        <input type="url" id="linkedin_url" name="linkedin_url" class="form-control" 
                               value="{{ old('linkedin_url', $user->profile?->linkedin_url) }}" 
                               placeholder="https://linkedin.com/in/yourprofile">
                    </div>

                    <!-- Skills -->
                    <div class="form-group">
                        <label class="form-label">Skills</label>
                        <div class="skills-input-container">
                            <div class="skills-display" id="skillsDisplay">
                                @if($user->profile?->skills)
                                    @foreach($user->profile->skills as $skill)
                                        <span class="skill-tag">
                                            {{ $skill }}
                                            <button type="button" class="skill-remove" onclick="removeSkill(this)">×</button>
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            <input type="text" id="skillInput" class="form-control" 
                                   placeholder="Type a skill and press Enter" 
                                   onkeypress="addSkill(event)">
                            <input type="hidden" name="skills" id="skillsHidden" 
                                   value="{{ old('skills', $user->profile?->skills ? json_encode($user->profile->skills) : '[]') }}">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('user.profile') }}" class="btn-linkedin-secondary">Cancel</a>
                    <button type="submit" class="btn-linkedin-primary">Save changes</button>
                </div>
            </form>
        </div>

        <!-- Location Information -->
        <div class="edit-section">
            <div class="section-header">
                <h2 class="section-title">Location</h2>
            </div>
            <form action="{{ route('profile.update.basic') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" id="country" name="country" class="form-control" 
                                       value="{{ old('country', $user->profile?->country) }}" 
                                       placeholder="e.g. United States">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state" class="form-label">State/Province</label>
                                <input type="text" id="state" name="state" class="form-control" 
                                       value="{{ old('state', $user->profile?->state) }}" 
                                       placeholder="e.g. California">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city" class="form-label">City</label>
                                <input type="text" id="city" name="city" class="form-control" 
                                       value="{{ old('city', $user->profile?->city) }}" 
                                       placeholder="e.g. San Francisco">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal_code" class="form-label">Postal code</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-control" 
                                       value="{{ old('postal_code', $user->profile?->postal_code) }}" 
                                       placeholder="e.g. 94105">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea id="address" name="address" class="form-control" rows="2" 
                                  placeholder="Street address">{{ old('address', $user->profile?->address) }}</textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('user.profile') }}" class="btn-linkedin-secondary">Cancel</a>
                    <button type="submit" class="btn-linkedin-primary">Save changes</button>
                </div>
            </form>
        </div>

        <!-- Profile Pictures -->
        <div class="edit-section">
            <div class="section-header">
                <h2 class="section-title">Profile Pictures</h2>
            </div>
            <form action="{{ route('profile.update.pictures') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="section-body">
                    <!-- Profile Picture -->
                    <div class="profile-photo-section">
                        <div class="current-photo">
                            <img src="{{ $user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0a66c2&color=ffffff&size=120' }}" 
                                 alt="Profile picture" id="profilePreview">
                        </div>
                        <div class="photo-controls">
                            <h4>Profile picture</h4>
                            <p>A professional headshot is recommended. JPG, PNG or GIF. Max size 2MB.</p>
                            <div class="file-input-wrapper">
                                <button type="button" class="btn-linkedin-secondary">Choose file</button>
                                <input type="file" name="profile_picture" class="file-input" accept="image/*" onchange="previewImage(this, 'profilePreview')">
                            </div>
                        </div>
                    </div>

                    <!-- Cover Photo -->
                    <div class="form-group">
                        <label class="form-label">Cover photo</label>
                        <p style="font-size: 14px; color: rgba(0,0,0,.6); margin-bottom: 12px;">
                            Add a cover photo to make your profile stand out. JPG, PNG or GIF. Max size 5MB.
                        </p>
                        <div class="file-input-wrapper">
                            <button type="button" class="btn-linkedin-secondary">Choose cover photo</button>
                            <input type="file" name="cover_photo" class="file-input" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('user.profile') }}" class="btn-linkedin-secondary">Cancel</a>
                    <button type="submit" class="btn-linkedin-primary">Save pictures</button>
                </div>
            </form>
        </div>

        <!-- Privacy Settings -->
        <div class="edit-section">
            <div class="section-header">
                <h2 class="section-title">Privacy Settings</h2>
            </div>
            <form action="{{ route('profile.update.privacy') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="section-body">
                    <div class="form-check">
                        <input type="checkbox" id="profile_public" name="profile_public" class="form-check-input" 
                               value="1" {{ old('profile_public', $user->profile?->profile_public ?? true) ? 'checked' : '' }}>
                        <label for="profile_public" class="form-check-label">Make my profile public</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="show_email" name="show_email" class="form-check-input" 
                               value="1" {{ old('show_email', $user->profile?->show_email ?? false) ? 'checked' : '' }}>
                        <label for="show_email" class="form-check-label">Show my email address</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="show_phone" name="show_phone" class="form-check-input" 
                               value="1" {{ old('show_phone', $user->profile?->show_phone ?? false) ? 'checked' : '' }}>
                        <label for="show_phone" class="form-check-label">Show my phone number</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="show_location" name="show_location" class="form-check-input" 
                               value="1" {{ old('show_location', $user->profile?->show_location ?? true) ? 'checked' : '' }}>
                        <label for="show_location" class="form-check-label">Show my location</label>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('user.profile') }}" class="btn-linkedin-secondary">Cancel</a>
                    <button type="submit" class="btn-linkedin-primary">Save privacy settings</button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="edit-section">
            <div class="section-header">
                <h2 class="section-title">Change Password</h2>
            </div>
            <form action="{{ route('profile.change.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="section-body">
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current password *</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">New password *</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm new password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('user.profile') }}" class="btn-linkedin-secondary">Cancel</a>
                    <button type="submit" class="btn-linkedin-primary">Change password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Skills management
function addSkill(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const input = event.target;
        const skill = input.value.trim();
        
        if (skill && !isSkillExists(skill)) {
            const skillsDisplay = document.getElementById('skillsDisplay');
            const skillTag = document.createElement('span');
            skillTag.className = 'skill-tag';
            skillTag.innerHTML = `
                ${skill}
                <button type="button" class="skill-remove" onclick="removeSkill(this)">×</button>
            `;
            skillsDisplay.appendChild(skillTag);
            
            input.value = '';
            updateSkillsHidden();
        }
    }
}

function removeSkill(button) {
    button.parentElement.remove();
    updateSkillsHidden();
}

function isSkillExists(skill) {
    const existingSkills = document.querySelectorAll('.skill-tag');
    for (let skillTag of existingSkills) {
        if (skillTag.textContent.trim().replace('×', '') === skill) {
            return true;
        }
    }
    return false;
}

function updateSkillsHidden() {
    const skillTags = document.querySelectorAll('.skill-tag');
    const skills = Array.from(skillTags).map(tag => tag.textContent.trim().replace('×', ''));
    document.getElementById('skillsHidden').value = JSON.stringify(skills);
}

// Image preview
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Initialize skills on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSkillsHidden();
});
</script>
@endsection