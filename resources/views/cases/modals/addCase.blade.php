<!-- Add Case Modal -->
<div class="modal fade" id="addCaseModal" tabindex="-1" aria-labelledby="addCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="addCaseModalLabel" style="font-size: 25px">Add New Case</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cases.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control form-control-sm @error('case_title') is-invalid @enderror"
                                id="case_title" name="case_title" value="{{ old('case_title') }}"
                                placeholder="Case Title" required>
                            <label for="case_title">Case Title</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <select class="form-select form-select-sm @error('case_type') is-invalid @enderror"
                                id="case_type" name="case_type" required>
                                <option value="" disabled {{ old('case_type') ? '' : 'selected' }}>Select...
                                </option>
                                <option value="Abuse" {{ old('case_type') === 'Abuse' ? 'selected' : '' }}>Abuse
                                </option>
                                <option value="Neglect" {{ old('case_type') === 'Neglect' ? 'selected' : '' }}>Neglect
                                </option>
                                <option value="Support" {{ old('case_type') === 'Support' ? 'selected' : '' }}>Support
                                </option>
                                <option value="Other" {{ old('case_type') === 'Other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                            <label for="case_type">Case Type</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control form-control-sm @error('guardian_name') is-invalid @enderror"
                                id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}"
                                placeholder="Guardian Name" required>
                            <label for="guardian_name">Guardian Name</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="number"
                                class="form-control form-control-sm @error('guardian_contact') is-invalid @enderror"
                                id="guardian_contact" name="guardian_contact" value="{{ old('guardian_contact') }}"
                                placeholder="Guardian Contact" required>
                            <label for="guardian_contact">Guardian Contact</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control form-control-sm @error('notes') is-invalid @enderror" id="notes" name="notes"
                                placeholder="Enter any additional case details..." style="height: 120px">{{ old('notes') }}</textarea>
                            <label for="notes">Notes</label>
                        </div>
                    </div>

                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Case
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Edit Case Modal -->
<div class="modal fade" id="editCaseModal" tabindex="-1" aria-labelledby="editCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bolder" id="editCaseModalLabel" style="font-size: 25px">Edit Case</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCaseForm" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hidden Case ID -->
                    <input type="hidden" id="case_id" name="id">

                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control form-control-sm @error('case_title') is-invalid @enderror"
                                    id="edit_case_title" name="case_title" placeholder="Case Title" required>
                                <label for="edit_case_title">Case Title</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select form-select-sm @error('case_type') is-invalid @enderror"
                                    id="edit_case_type" name="case_type" required>
                                    <option value="" disabled>Select...</option>
                                    <option value="Abuse">Abuse</option>
                                    <option value="Neglect">Neglect</option>
                                    <option value="Support">Support</option>
                                    <option value="Other">Other</option>
                                </select>
                                <label for="edit_case_type">Case Type</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control form-control-sm @error('guardian_name') is-invalid @enderror"
                                    id="edit_guardian_name" name="guardian_name" placeholder="Guardian Name"
                                    required>
                                <label for="edit_guardian_name">Guardian Name</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control form-control-sm @error('guardian_contact') is-invalid @enderror"
                                    id="edit_guardian_contact" name="guardian_contact" placeholder="Guardian Contact"
                                    required>
                                <label for="edit_guardian_contact">Guardian Contact</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select form-select-sm @error('status') is-invalid @enderror"
                                    id="edit_status" name="status" required>
                                    <option value="" disabled>Select...</option>
                                    <option value="open">Open</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="closed">Closed</option>
                                    <option value="resolved">Resolved</option>
                                </select>
                                <label for="edit_status">Status</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <textarea class="form-control form-control-sm @error('notes') is-invalid @enderror" id="edit_notes" name="notes"
                                    placeholder="Enter details..." style="height: 100px"></textarea>
                                <label for="edit_notes">Notes</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".editCaseBtn").forEach(button => {
            button.addEventListener("click", function() {
                let caseId = this.getAttribute("data-id");
                let caseTitle = this.getAttribute("data-case_title");
                let caseType = this.getAttribute("data-case_type");
                let caseGname = this.getAttribute("data-guardian_name");
                let caseGcontact = this.getAttribute("data-guardian_contact");
                let caseNotes = this.getAttribute("data-notes");
                let caseStatus = this.getAttribute("data-status");

                // Set form action dynamically
                document.getElementById("editCaseForm").action = `/cases/${caseId}`;

                // Populate modal fields
                document.getElementById("case_id").value = caseId;
                document.getElementById("edit_case_title").value = caseTitle;
                document.getElementById("edit_guardian_name").value = caseGname;
                document.getElementById("edit_guardian_contact").value = caseGcontact;
                document.getElementById("edit_notes").value = caseNotes;

                // Set the selected value in the case type dropdown
                let caseTypeDropdown = document.getElementById("edit_case_type");
                for (let option of caseTypeDropdown.options) {
                    if (option.value === caseType) {
                        option.selected = true;
                        break;
                    }
                }

                // Set the selected value in the status dropdown
                let statusDropdown = document.getElementById("edit_status");
                for (let option of statusDropdown.options) {
                    if (option.value === caseStatus) {
                        option.selected = true;
                        break;
                    }
                }
            });
        });
    });
</script>




<script>
    // Set the selected role in dropdown
    let roleDropdown = document.getElementById("edit_role");
    if (roleDropdown) {
        for (let option of roleDropdown.options) {
            if (option.value === userRole) {
                option.selected = true;
                break;
            }
        }
    }
    });
    })
    });
</script>
