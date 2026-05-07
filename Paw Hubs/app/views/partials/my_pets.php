<?php
if (!function_exists('asset')) {
    function asset($path) {
        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($base === '/' || $base === '.') {
            $base = '';
        }
        return $base . '/' . ltrim($path, '/');
    }
}

$petUploadsBase = $petUploadsBase ?? asset('uploads/pets');
$defaultPetImage = $defaultPetImage ?? asset('images/guest.png');
$pets = $pets ?? [];
?>

<section class="panel my-pets" id="my-pets">
    <div class="panel-header">
        <h2>My Pets</h2>
    </div>
    <div class="pets-grid">
        <?php if (empty($pets)): ?>
            <div class="empty-pets-state">No pets added yet. Add your first companion to begin tracking.</div>
        <?php endif; ?>

        <?php foreach ($pets as $pet): ?>
            <?php
            $petImage = trim((string) ($pet['image'] ?? ''));
            $petImage = pathinfo($petImage, PATHINFO_BASENAME);
            $petImage = $petImage !== '' ? $petUploadsBase . '/' . htmlspecialchars($petImage) : $defaultPetImage;
            $petData = htmlspecialchars(json_encode($pet), ENT_QUOTES, 'UTF-8');
            $badgeText = !empty($pet['vaccination_status']) && strtolower($pet['vaccination_status']) !== 'unknown'
                ? htmlspecialchars($pet['vaccination_status'])
                : 'Vaccine status pending';
            ?>
            <article class="pet-card" data-pet-id="<?= (int) $pet['id'] ?>" data-pet='<?= $petData ?>'>
                <div class="pet-card-ribbon"><span><?= $badgeText ?></span></div>
                <div class="pet-image">
                    <img src="<?= $petImage ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="pet-image-thumb" onerror="this.onerror=null;this.src='<?= htmlspecialchars($defaultPetImage, ENT_QUOTES, 'UTF-8') ?>'">
                </div>
                <h3><?= htmlspecialchars($pet['name']) ?></h3>
                <p class="pet-meta"><?= htmlspecialchars($pet['species']) ?> · <?= htmlspecialchars($pet['breed'] ?: 'Unknown breed') ?></p>
                <div class="pet-stats-row">
                    <span><?= (int) $pet['age'] ?> yrs</span>
                    <span><?= htmlspecialchars($pet['color'] ?: 'No color') ?></span>
                </div>
                <button type="button" class="view-details-btn">View Details <i class="fas fa-arrow-right"></i></button>
            </article>
        <?php endforeach; ?>

        <article class="pet-card add-card" id="openPetModalButton">
            <div class="add-avatar"><i class="fas fa-plus"></i></div>
            <h3>Add New Pet</h3>
            <p class="pet-meta">Add your pet to get started</p>
        </article>
    </div>
</section>

<div class="pet-modal-overlay" id="petModalBackdrop" aria-hidden="true">
    <div class="pet-modal" role="dialog" aria-modal="true" aria-labelledby="petModalTitle">
        <button type="button" class="close-modal" id="closePetModal"><i class="fas fa-times"></i></button>
        <div class="pet-modal-left">
            <div class="pet-image-panel">
                <div class="pet-image-header">
                    <h3>Upload pet photo</h3>
                    <p>Choose a clear image so your pet profile looks premium.</p>
                </div>
                <div class="pet-preview">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 180 180'%3E%3Crect width='180' height='180' fill='%23eef7f4'/%3E%3Ccircle cx='90' cy='94' r='60' fill='%23dff3ec'/%3E%3Ccircle cx='90' cy='64' r='30' fill='%239ad1b8'/%3E%3Ccircle cx='70' cy='56' r='7' fill='%237fae99'/%3E%3Ccircle cx='110' cy='56' r='7' fill='%237fae99'/%3E%3C/svg%3E" alt="Pet preview" id="petPreviewImg">
                </div>
                <label for="petImageInput" class="upload-dropzone">
                    <div class="upload-dropzone-inner">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <strong>Upload photo</strong>
                        <span>PNG, JPG or WEBP</span>
                    </div>
                    <input id="petImageInput" name="pet_image" type="file" accept="image/jpeg,image/png,image/webp" form="addPetForm">
                </label>
                <p class="upload-note">Use a square or portrait image for the best result.</p>
            </div>
        </div>
        <div class="pet-modal-right">
            <div class="modal-header">
                <span class="modal-tag">New Pet</span>
                <h2 id="petModalTitle">Add a pet to your care circle</h2>
                <p>Capture pet details and medical notes so everything stays ready for visits and wellness checks.</p>
            </div>
            <form id="addPetForm" class="pet-form" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="pet-form-field">
                        <label for="petName">Pet Name</label>
                        <input id="petName" name="name" type="text" placeholder="e.g. Luna" required>
                    </div>
                    <div class="pet-form-field">
                        <label for="petSpecies">Species</label>
                        <select id="petSpecies" name="species" required>
                            <option value="">Select species</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="pet-form-field">
                        <label for="petBreed">Breed</label>
                        <input id="petBreed" name="breed" type="text" placeholder="e.g. Labrador">
                    </div>
                    <div class="pet-form-field">
                        <label for="petAge">Age</label>
                        <input id="petAge" name="age" type="number" min="0" step="1" placeholder="Years" required>
                    </div>
                    <div class="pet-form-field">
                        <label for="petGender">Gender</label>
                        <select id="petGender" name="gender">
                            <option value="Unknown">Unknown</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="pet-form-field">
                        <label for="petWeight">Weight</label>
                        <input id="petWeight" name="weight" type="number" min="0" step="0.1" placeholder="kg">
                    </div>
                    <div class="pet-form-field">
                        <label for="petColor">Color</label>
                        <input id="petColor" name="color" type="text" placeholder="e.g. Golden">
                    </div>
                    <div class="pet-form-field">
                        <label for="petVaccinationStatus">Vaccination Status</label>
                        <input id="petVaccinationStatus" name="vaccination_status" type="text" placeholder="e.g. Up to date">
                    </div>
                    <div class="pet-form-field form-full">
                        <label for="petMedicalNotes">Medical Notes</label>
                        <textarea id="petMedicalNotes" name="medical_notes" placeholder="Allergies, medications, behavior notes" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn secondary" id="cancelPetModal">Cancel</button>
                    <button type="submit" class="btn primary add-pet-btn">Add Pet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="pet-detail-overlay" id="petDetailOverlay" aria-hidden="true">
    <div class="pet-detail-modal" role="dialog" aria-modal="true" aria-labelledby="petDetailTitle">
        <button type="button" class="close-modal" id="closeDetailModal"><i class="fas fa-times"></i></button>
        <div class="pet-detail-content">
            <div class="pet-detail-left">
                <div class="pet-detail-image">
                    <img id="detailPetImage" src="<?= htmlspecialchars($defaultPetImage) ?>" alt="Pet image">
                </div>
                <div class="pet-detail-badge" id="detailPetStatus"></div>
            </div>
            <div class="pet-detail-right">
                <div class="pet-detail-header">
                    <span class="modal-tag">Pet Profile</span>
                    <h2 id="petDetailTitle"></h2>
                    <p id="petDetailSubtitle"></p>
                </div>
                <div class="detail-actions">
                    <button type="button" class="btn secondary edit-pet-btn" id="detailEditButton">Edit</button>
                    <button type="button" class="btn danger delete-pet-btn" id="detailDeleteButton">Delete</button>
                </div>
                <div class="pet-detail-grid">
                    <div><strong>Species</strong><span id="detailSpecies"></span></div>
                    <div><strong>Breed</strong><span id="detailBreed"></span></div>
                    <div><strong>Age</strong><span id="detailAge"></span></div>
                    <div><strong>Gender</strong><span id="detailGender"></span></div>
                    <div><strong>Weight</strong><span id="detailWeight"></span></div>
                    <div><strong>Color</strong><span id="detailColor"></span></div>
                    <div><strong>Vaccination</strong><span id="detailVaccination"></span></div>
                    <div><strong>Created</strong><span id="detailCreated"></span></div>
                </div>
                <div class="pet-detail-notes">
                    <strong>Medical notes</strong>
                    <p id="detailNotes"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pet-detail-overlay" id="petEditOverlay" aria-hidden="true">
    <div class="pet-detail-modal" role="dialog" aria-modal="true" aria-labelledby="editPetTitle">
        <button type="button" class="close-modal" id="closeEditModal"><i class="fas fa-times"></i></button>
        <div class="pet-detail-content">
            <div class="pet-modal-left">
                <div class="pet-image-panel">
                    <div class="pet-image-header">
                        <h3>Change Pet Photo</h3>
                        <p>Upload a new image to update your pet's profile picture.</p>
                    </div>
                    <div class="pet-preview">
                        <img id="editPetImagePreview" src="<?= htmlspecialchars($defaultPetImage) ?>" alt="Edit pet image">
                    </div>
                    <div class="upload-dropzone" id="editUploadDropzone">
                        <div class="upload-dropzone-inner">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <strong>Upload New Image</strong>
                            <span>Drag & drop or click to select</span>
                        </div>
                        <input type="file" name="pet_image" id="editPetImage" accept="image/*" form="editPetForm">
                    </div>
                    <p class="upload-note">Supported formats: JPG, PNG, WebP. Max size: 5MB.</p>
                </div>
            </div>
            <div class="pet-modal-right">
                <div class="modal-header">
                    <span class="modal-tag">Edit Pet</span>
                    <h2 id="editPetTitle">Update pet details</h2>
                    <p>Keep your pet's profile up to date with the latest information.</p>
                </div>
                <form id="editPetForm" class="pet-form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editPetId">
                    <div class="form-grid">
                        <div class="pet-form-field">
                            <label for="editPetName">Pet Name</label>
                            <input id="editPetName" name="name" type="text" placeholder="e.g. Luna" required>
                        </div>
                        <div class="pet-form-field">
                            <label for="editSpecies">Species</label>
                            <select id="editSpecies" name="species" required>
                                <option value="">Select species</option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Bird">Bird</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="pet-form-field">
                            <label for="editBreed">Breed</label>
                            <input id="editBreed" name="breed" type="text" placeholder="e.g. Labrador">
                        </div>
                        <div class="pet-form-field">
                            <label for="editAge">Age</label>
                            <input id="editAge" name="age" type="number" placeholder="Age in years" min="0" required>
                        </div>
                        <div class="pet-form-field">
                            <label for="editGender">Gender</label>
                            <select id="editGender" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Unknown">Unknown</option>
                            </select>
                        </div>
                        <div class="pet-form-field">
                            <label for="editWeight">Weight</label>
                            <input id="editWeight" name="weight" type="text" placeholder="e.g. 5.5 kg">
                        </div>
                        <div class="pet-form-field">
                            <label for="editColor">Color</label>
                            <input id="editColor" name="color" type="text" placeholder="e.g. Brown, White">
                        </div>
                        <div class="pet-form-field">
                            <label for="editVaccination">Vaccination Status</label>
                            <input id="editVaccination" name="vaccination_status" type="text" placeholder="e.g. Up to date">
                        </div>
                    </div>
                    <div class="pet-form-field wide-field">
                        <label for="editMedicalNotes">Medical Notes</label>
                        <textarea id="editMedicalNotes" name="medical_notes" placeholder="Allergies, medications, behavior notes" rows="4"></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn secondary" id="cancelEditButton">Cancel</button>
                        <button type="submit" class="btn">Save Changes</button>
                        <button type="button" class="btn danger" id="deleteFromEditButton">Delete Pet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="confirm-overlay" id="confirmDeleteOverlay" aria-hidden="true">
    <div class="confirm-modal">
        <p class="confirm-title">Delete pet profile?</p>
        <p class="confirm-text">This action cannot be undone. The pet profile will be permanently removed.</p>
        <div class="confirm-actions">
            <button type="button" class="btn secondary" id="cancelDeleteButton">Cancel</button>
            <button type="button" class="btn danger" id="confirmDeleteButton">Delete</button>
        </div>
    </div>
</div>

<div class="toast-message" id="petToast" role="status" aria-live="polite"></div>
