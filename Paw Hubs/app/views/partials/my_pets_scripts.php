<script>
const openPetModalButton = document.getElementById('openPetModalButton');
const petModalBackdrop = document.getElementById('petModalBackdrop');
const closePetModal = document.getElementById('closePetModal');
const cancelPetModal = document.getElementById('cancelPetModal');
const addPetForm = document.getElementById('addPetForm');
const petPreviewImg = document.getElementById('petPreviewImg');
const petImageInput = document.getElementById('petImageInput');
const uploadDropzone = document.querySelector('.upload-dropzone');
const detailOverlay = document.getElementById('petDetailOverlay');
const closeDetailModal = document.getElementById('closeDetailModal');
const editOverlay = document.getElementById('petEditOverlay');
const closeEditModal = document.getElementById('closeEditModal');
const cancelEditButton = document.getElementById('cancelEditButton');
const confirmDeleteOverlay = document.getElementById('confirmDeleteOverlay');
const cancelDeleteButton = document.getElementById('cancelDeleteButton');
const confirmDeleteButton = document.getElementById('confirmDeleteButton');
const detailPetImage = document.getElementById('detailPetImage');
const detailPetStatus = document.getElementById('detailPetStatus');
const detailPetTitle = document.getElementById('petDetailTitle');
const detailSubtitle = document.getElementById('petDetailSubtitle');
const detailSpecies = document.getElementById('detailSpecies');
const detailBreed = document.getElementById('detailBreed');
const detailAge = document.getElementById('detailAge');
const detailGender = document.getElementById('detailGender');
const detailWeight = document.getElementById('detailWeight');
const detailColor = document.getElementById('detailColor');
const detailVaccination = document.getElementById('detailVaccination');
const detailNotes = document.getElementById('detailNotes');
const detailCreated = document.getElementById('detailCreated');
const detailEditButton = document.getElementById('detailEditButton');
const detailDeleteButton = document.getElementById('detailDeleteButton');
const editPetForm = document.getElementById('editPetForm');
const editPetId = document.getElementById('editPetId');
const editPetName = document.getElementById('editPetName');
const editSpecies = document.getElementById('editSpecies');
const editBreed = document.getElementById('editBreed');
const editAge = document.getElementById('editAge');
const editGender = document.getElementById('editGender');
const editWeight = document.getElementById('editWeight');
const editColor = document.getElementById('editColor');
const editVaccination = document.getElementById('editVaccination');
const editMedicalNotes = document.getElementById('editMedicalNotes');
const editPetImage = document.getElementById('editPetImage');
const editPetImagePreview = document.getElementById('editPetImagePreview');
const editUploadDropzone = document.getElementById('editUploadDropzone');
const deleteFromEditButton = document.getElementById('deleteFromEditButton');
const petToast = document.getElementById('petToast');
const petsGrid = document.querySelector('.pets-grid');
const detailOverlayType = document.getElementById('petDetailOverlay');
const petUploadsBase = <?= json_encode($petUploadsBase) ?>;
const defaultPetImage = <?= json_encode($defaultPetImage) ?>;
const defaultPetPlaceholder = 'data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 400 400%27%3E%3Crect width=%27400%27 height=%27400%27 fill=%27%23f5f7f6%27/%3E%3Ccircle cx=%27200%27 cy=%27208%27 r=%27130%27 fill=%27%23def4ea%27/%3E%3Ccircle cx=%27200%27 cy=%27140%27 r=%2772%27 fill=%27%239ad1b8%27/%3E%3Ccircle cx=%27150%27 cy=%27120%27 r=%2716%27 fill=%27%237fae99%27/%3E%3Ccircle cx=%27250%27 cy=%27120%27 r=%2716%27 fill=%27%237fae99%27/%3E%3C/svg%3E';

const showPetModal = () => {
    petModalBackdrop.classList.add('show');
    petModalBackdrop.setAttribute('aria-hidden', 'false');
};

const hidePetModal = () => {
    petModalBackdrop.classList.remove('show');
    petModalBackdrop.setAttribute('aria-hidden', 'true');
    addPetForm.reset();
    petPreviewImg.src = defaultPetPlaceholder;
};

const openPetDetailOverlay = () => {
    detailOverlay.classList.add('show');
    detailOverlay.setAttribute('aria-hidden', 'false');
};

const closePetDetailOverlay = () => {
    detailOverlay.classList.remove('show');
    detailOverlay.setAttribute('aria-hidden', 'true');
};

const openEditOverlay = () => {
    editOverlay.classList.add('show');
    editOverlay.setAttribute('aria-hidden', 'false');
};

const closeEditOverlay = () => {
    editOverlay.classList.remove('show');
    editOverlay.setAttribute('aria-hidden', 'true');
};

const showConfirmDelete = () => {
    confirmDeleteOverlay.classList.add('show');
    confirmDeleteOverlay.setAttribute('aria-hidden', 'false');
};

const closeConfirmDelete = () => {
    confirmDeleteOverlay.classList.remove('show');
    confirmDeleteOverlay.setAttribute('aria-hidden', 'true');
};

const buildPetImageUrl = (imageName) => {
    const cleanName = (imageName || '').toString().split('/').pop().split('\\\\').pop();
    return cleanName ? `${petUploadsBase}/${cleanName}` : defaultPetImage;
};

const showToast = (message, type = 'success') => {
    if (!petToast) return;
    petToast.textContent = message;
    petToast.dataset.state = type;
    petToast.classList.add('show');
    window.clearTimeout(showToast.timeoutId);
    showToast.timeoutId = window.setTimeout(() => petToast.classList.remove('show'), 3200);
};

const updatePetCard = (updatedPet) => {
    const card = document.querySelector(`.pet-card[data-pet-id="${updatedPet.id}"]`);
    if (!card) return;
    card.dataset.pet = JSON.stringify(updatedPet);
    card.querySelector('.pet-image-thumb').src = buildPetImageUrl(updatedPet.image);
    card.querySelector('.pet-image-thumb').alt = updatedPet.name || 'Pet image';
    card.querySelector('h3').textContent = updatedPet.name || 'Unnamed pet';
    card.querySelector('.pet-meta').textContent = `${updatedPet.species || 'Unknown'} · ${updatedPet.breed || 'Unknown breed'}`;
    const stats = card.querySelector('.pet-stats-row');
    if (stats) {
        stats.innerHTML = `<span>${escapeHtml(String(updatedPet.age || '0'))} yrs</span><span>${escapeHtml(updatedPet.color || 'No color')}</span>`;
    }
    const ribbon = card.querySelector('.pet-card-ribbon span');
    if (ribbon) {
        ribbon.textContent = updatedPet.vaccination_status && updatedPet.vaccination_status !== 'Unknown'
            ? updatedPet.vaccination_status
            : 'Vaccine status pending';
    }
};

const showPetDetails = (pet) => {
    const imageUrl = buildPetImageUrl(pet.image);
    detailPetImage.src = imageUrl;
    detailPetImage.onerror = () => { detailPetImage.src = defaultPetImage; };
    detailPetImage.alt = pet.name ? `${pet.name} profile` : 'Pet image';
    detailPetStatus.textContent = pet.vaccination_status && pet.vaccination_status !== 'Unknown' ? pet.vaccination_status : 'Vaccine status pending';
    detailPetTitle.textContent = pet.name || 'Unnamed pet';
    detailSubtitle.textContent = `${pet.species || 'Species unknown'} · ${pet.breed || 'Unknown breed'}`;
    detailSpecies.textContent = pet.species || 'Unknown';
    detailBreed.textContent = pet.breed || 'Unknown';
    detailAge.textContent = pet.age ? `${pet.age} years` : 'Unknown';
    detailGender.textContent = pet.gender || 'Unknown';
    detailWeight.textContent = pet.weight ? `${pet.weight} kg` : 'Unknown';
    detailColor.textContent = pet.color || 'Unknown';
    detailVaccination.textContent = pet.vaccination_status || 'Unknown';
    detailNotes.textContent = pet.medical_notes || 'No medical notes available.';
    detailCreated.textContent = pet.created_at ? new Date(pet.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'Unknown';
    detailOverlay.classList.add('show');
    detailOverlay.dataset.currentPet = pet.id || '';
};

const openEditPetForm = (pet) => {
    editPetId.value = pet.id || '';
    editPetName.value = pet.name || '';
    editSpecies.value = pet.species || '';
    editBreed.value = pet.breed || '';
    editAge.value = pet.age || '';
    editGender.value = pet.gender || 'Unknown';
    editWeight.value = pet.weight || '';
    editColor.value = pet.color || '';
    editVaccination.value = pet.vaccination_status || '';
    editMedicalNotes.value = pet.medical_notes || '';
    editPetImagePreview.src = buildPetImageUrl(pet.image);
    openEditOverlay();
};

const deletePet = async (petId) => {
    try {
        const response = await fetch('index.php?url=home/deletePet', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${encodeURIComponent(petId)}`
        });
        const json = await response.json();
        if (!json.success) {
            showToast(json.message || 'Could not delete pet.', 'error');
            return;
        }
        const card = document.querySelector(`.pet-card[data-pet-id="${petId}"]`);
        if (card) card.remove();
        closeConfirmDelete();
        closeEditOverlay();
        showToast(json.message || 'Pet deleted successfully.', 'success');
        pushNavbarNotification('Pet Deleted', 'A pet profile was removed from your account.');
    } catch (error) {
        showToast('Unable to delete pet. Please try again.', 'error');
    }
};

const pushNavbarNotification = (title, message) => {
    const navbarNotificationToggle = document.getElementById('notificationToggle');
    const navbarNotificationsDropdown = document.getElementById('notificationsDropdown');
    if (!navbarNotificationToggle || !navbarNotificationsDropdown) return;

    let badge = navbarNotificationToggle.querySelector('.badge');
    if (!badge) {
        badge = document.createElement('span');
        badge.className = 'badge';
        navbarNotificationToggle.appendChild(badge);
    }

    const currentCount = parseInt(badge.textContent || '0', 10) || 0;
    const nextCount = currentCount + 1;
    badge.textContent = String(nextCount);

    const statusLabel = navbarNotificationsDropdown.querySelector('.notification-card-header span');
    if (statusLabel) {
        statusLabel.textContent = `${nextCount} unread`;
    }

    const list = navbarNotificationsDropdown.querySelector('.notification-list');
    if (!list) return;

    const empty = list.querySelector('.notification-empty');
    if (empty) {
        empty.remove();
    }

    const item = document.createElement('article');
    item.className = 'notification-item unread';
    item.innerHTML = `
        <div class="notification-body">
            <div class="notification-title">${escapeHtml(title)}</div>
            <div class="notification-message">${escapeHtml(message)}</div>
        </div>
        <small class="notification-time">Just now</small>
    `;
    list.prepend(item);

    while (list.children.length > 10) {
        list.removeChild(list.lastElementChild);
    }
};

const escapeHtml = (text) => {
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
};

const initializePetControls = () => {
    if (openPetModalButton) {
        openPetModalButton.addEventListener('click', showPetModal);
    }

    if (petModalBackdrop) {
        petModalBackdrop.addEventListener('click', (event) => {
            if (event.target === petModalBackdrop) {
                hidePetModal();
            }
        });
    }

    if (closePetModal) {
        closePetModal.addEventListener('click', hidePetModal);
    }

    if (cancelPetModal) {
        cancelPetModal.addEventListener('click', hidePetModal);
    }

    if (detailOverlay) {
        detailOverlay.addEventListener('click', (event) => {
            if (event.target === detailOverlay) {
                closePetDetailOverlay();
            }
        });
    }

    if (closeDetailModal) {
        closeDetailModal.addEventListener('click', closePetDetailOverlay);
    }

    if (detailEditButton) {
        detailEditButton.addEventListener('click', () => {
            const pet = JSON.parse(detailOverlay.dataset.currentPet || '{}');
            openEditPetForm(pet);
        });
    }

    if (detailDeleteButton) {
        detailDeleteButton.addEventListener('click', () => {
            showConfirmDelete();
        });
    }

    if (editOverlay) {
        editOverlay.addEventListener('click', (event) => {
            if (event.target === editOverlay) {
                closeEditOverlay();
            }
        });
    }

    if (closeEditModal) {
        closeEditModal.addEventListener('click', closeEditOverlay);
    }

    if (cancelEditButton) {
        cancelEditButton.addEventListener('click', closeEditOverlay);
    }

    if (confirmDeleteOverlay) {
        confirmDeleteOverlay.addEventListener('click', (event) => {
            if (event.target === confirmDeleteOverlay) {
                closeConfirmDelete();
            }
        });
    }

    if (cancelDeleteButton) {
        cancelDeleteButton.addEventListener('click', closeConfirmDelete);
    }

    if (petImageInput) {
        petImageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (!file) {
                petPreviewImg.src = defaultPetPlaceholder;
                return;
            }
            const reader = new FileReader();
            reader.onload = () => {
                petPreviewImg.src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    }

    if (uploadDropzone) {
        uploadDropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            uploadDropzone.classList.add('dragover');
        });

        uploadDropzone.addEventListener('dragleave', (event) => {
            event.preventDefault();
            uploadDropzone.classList.remove('dragover');
        });

        uploadDropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            uploadDropzone.classList.remove('dragover');
            const files = event.dataTransfer.files;
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                petImageInput.files = files;
                petImageInput.dispatchEvent(new Event('change'));
            } else {
                showToast('Please drop a valid image file.', 'error');
            }
        });
    }

    if (editUploadDropzone) {
        editUploadDropzone.addEventListener('click', () => {
            editPetImage.click();
        });
        editUploadDropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            editUploadDropzone.classList.add('dragover');
        });
        editUploadDropzone.addEventListener('dragleave', (event) => {
            event.preventDefault();
            editUploadDropzone.classList.remove('dragover');
        });
        editUploadDropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            editUploadDropzone.classList.remove('dragover');
            const files = event.dataTransfer.files;
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                editPetImage.files = files;
                editPetImage.dispatchEvent(new Event('change'));
            } else {
                showToast('Please drop a valid image file.', 'error');
            }
        });
    }

    if (editPetImage) {
        editPetImage.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (!file) {
                return;
            }
            const reader = new FileReader();
            reader.onload = () => {
                editPetImagePreview.src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    }

    if (deleteFromEditButton) {
        deleteFromEditButton.addEventListener('click', () => {
            const petId = editPetId.value;
            const petName = editPetName.value;
            if (confirm(`Are you sure you want to delete ${petName}? This action cannot be undone.`)) {
                deletePet(petId);
            }
        });
    }

    if (addPetForm) {
        addPetForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(addPetForm);
            const response = await fetch('index.php?url=home/addPet', {
                method: 'POST',
                body: formData
            });

            const json = await response.json();
            if (!json.success) {
                showToast(json.message || 'Could not add pet.', 'error');
                return;
            }

            const newPet = json.pet;
            const card = document.createElement('article');
            card.className = 'pet-card';
            card.dataset.petId = newPet.id;
            card.dataset.pet = JSON.stringify(newPet);
            card.innerHTML = `
                <div class="pet-card-ribbon"><span>${escapeHtml(newPet.vaccination_status !== 'Unknown' && newPet.vaccination_status ? newPet.vaccination_status : 'Vaccine status pending')}</span></div>
                <div class="pet-image"><img src="${escapeHtml(buildPetImageUrl(newPet.image))}" alt="${escapeHtml(newPet.name)}" class="pet-image-thumb"></div>
                <h3>${escapeHtml(newPet.name)}</h3>
                <p class="pet-meta">${escapeHtml(newPet.species)} · ${escapeHtml(newPet.breed || 'Unknown breed')}</p>
                <div class="pet-stats-row">
                    <span>${escapeHtml(String(newPet.age || '0'))} yrs</span>
                    <span>${escapeHtml(newPet.color || 'No color')}</span>
                </div>
                <button type="button" class="view-details-btn">View Details <i class="fas fa-arrow-right"></i></button>
            `;

            const existingEmpty = document.querySelector('.empty-pets-state');
            if (existingEmpty) {
                existingEmpty.remove();
            }

            petsGrid.insertBefore(card, openPetModalButton);
            hidePetModal();
            const newImage = card.querySelector('.pet-image-thumb');
            if (newImage) {
                newImage.onerror = () => { newImage.src = defaultPetImage; };
            }
            showToast(json.message || 'Pet added successfully.', 'success');
            pushNavbarNotification('Pet Added', `${newPet.name || 'Your pet'} was added to your pets successfully.`);
        });
    }

    if (editPetForm) {
        editPetForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(editPetForm);
            const response = await fetch('index.php?url=home/editPet', {
                method: 'POST',
                body: formData
            });

            const json = await response.json();
            if (!json.success) {
                showToast(json.message || 'Could not update pet.', 'error');
                return;
            }

            const updatedPet = json.pet;
            updatePetCard(updatedPet);
            closeEditOverlay();
            showToast(json.message || 'Pet details updated successfully.', 'success');
            pushNavbarNotification('Pet Updated', `${updatedPet.name || 'Your pet'} profile details were updated.`);
            if (detailOverlay.classList.contains('show') && detailOverlay.dataset.currentPet === String(updatedPet.id)) {
                showPetDetails(updatedPet);
            }
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            if (petModalBackdrop.classList.contains('show')) hidePetModal();
            if (detailOverlay.classList.contains('show')) closePetDetailOverlay();
            if (editOverlay.classList.contains('show')) closeEditOverlay();
            if (confirmDeleteOverlay.classList.contains('show')) closeConfirmDelete();
        }
    });

    const watchCards = () => {
        if (!petsGrid) return;
        petsGrid.addEventListener('click', (event) => {
            const card = event.target.closest('.pet-card');
            if (!card || card.classList.contains('add-card')) return;
            if (event.target.closest('.view-details-btn')) {
                const pet = JSON.parse(card.dataset.pet || '{}');
                showPetDetails(pet);
            }
        });
    };

    watchCards();
};

initializePetControls();
</script>
