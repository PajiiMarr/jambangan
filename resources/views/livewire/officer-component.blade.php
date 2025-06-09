@php
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
    // dd($isMobile);
@endphp

<div x-data="{ chartInitialized: false }" x-init="
    if (!chartInitialized) {
        initializeChart();
        chartInitialized = true;
    }
">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-2xl font-bold">Officers</h1>
        <div id="tree" wire:ignore></div>
    </div>

    <flux:modal.trigger class="hidden" name="edit-officer">
        <flux:button id="hidden-trigger">Edit profile</flux:button>
    </flux:modal.trigger>

    <flux:modal 
        name="edit-officer" 
        class="w-full md:w-123"
        :variant="$isMobile ? 'flyout' : null"
        :position="$isMobile ? 'bottom' : null"
    >
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Officer</flux:heading>
            </div>
            <div class="profile-picture">
                <img id="profile-picture-img" 
                     src="{{ $officer_input['photo'] ?? '' }}" 
                     alt="Profile Picture" 
                     class="w-32 h-32 rounded-full object-cover" />
            </div>

            <flux:input wire:model.live="officer_input.name" label="Name" placeholder="Enter name" id="flux-name" />
            <flux:input wire:model.live="officer_input.position" label="Position" placeholder="Enter position" id="flux-position" />
            <flux:input wire:model.live="officer_input.email" label="Email" placeholder="Enter email" id="flux-email" />
            <flux:input wire:model.live="officer_input.phone" label="Phone Number" placeholder="Enter phone number" id="flux-phone" />
            <flux:input wire:model.live="officer_input.address" label="Address" placeholder="Enter address" id="flux-address" />
            <flux:input wire:model.live="officer_input.pid" class="hidden" id="flux-pid" />
            <flux:input wire:model.live="officer_input.officer_id" class="hidden" id="flux-id" />
            <flux:label class="pb-3">Profile Picture </flux:label>
            <x-inputs.filepond label="Profile Picture" wire:model="profile_picture" />

            <div class="flex justify-end gap-2">
                <flux:button variant="ghost" id="flux-cancel">Cancel</flux:button>
                <flux:button wire:click="saveOfficer" variant="primary" id="flux-save">Save</flux:button>
            </div>
        </div>
    </flux:modal>

    <script>
        console.log("Chart Nodes:", @json($chartNodes));
        
    </script>

    <script>
    document.addEventListener('livewire:navigated', function() {
            window.dispatchEvent(new CustomEvent("flux:open", { detail: { name: "edit-officer" } }));
                        

            var editForm = function () {
                this.nodeId = null;
                this.isNewNode = false;  //
            };

            editForm.prototype.init = function (obj) {
                this.obj = obj;
                this.nameInput = document.getElementById("flux-name");
                this.positionInput = document.getElementById("flux-position");
                this.emailInput = document.getElementById("flux-email");
                this.phoneInput = document.getElementById("flux-phone");
                this.addressInput = document.getElementById("flux-address");
                this.parentIdInput = document.getElementById("flux-pid");
                this.nodeIdInput = document.getElementById("flux-id");
                this.cancelButton = document.getElementById("flux-cancel");
                this.saveButton = document.getElementById("flux-save");

                this.cancelButton.addEventListener("click", () => {
                    window.dispatchEvent(new CustomEvent("flux:close", { detail: { name: "edit-officer" } }));
                });
            };

            editForm.prototype.show = function (nodeId) {
                console.log("Modal should open for node:", nodeId);
                this.nodeId = nodeId;
                const node = this.obj.get(nodeId);
                console.log("Node data:", node); 

                this.clearForm();

                const profilePictureImg = document.getElementById("profile-picture-img");
                console.log("Profile Picture Image Element:", profilePictureImg);

                if (profilePictureImg && node) {
                    profilePictureImg.src = node.photo || '';
                }

                // Update Livewire state directly
                @this.set('officer_input', {
                    officer_id: nodeId,
                    name: node ? node.name || '' : '',
                    position: node ? node.position || '' : '',
                    email: node ? node.email || '' : '',
                    phone: node ? node.phone || '' : '',
                    address: node ? node.address || '' : '',
                    pid: node ? node.pid || null : null,
                    photo: node ? node.photo || '' : ''
                });
                @this.set('profile_picture', null);

                const hiddenTrigger = document.getElementById("hidden-trigger");
                if (hiddenTrigger) {
                    hiddenTrigger.click();
                }
            };

            editForm.prototype.hide = function () {
                window.dispatchEvent(new CustomEvent("flux:close", { detail: { name: "edit-officer" } }));
            };

            editForm.prototype.clearForm = function() {
                @this.set('officer_input', {
                    officer_id: null,
                    name: '',
                    position: '',
                    email: '',
                    phone: '',
                    address: '',
                    pid: null,
                    photo: ''
                });
                @this.set('profile_picture', null);
            };

            // Global chart initialization
            window.chart = new OrgChart("#tree", {
                showYScroll: true,
                mouseScrool: OrgChart.action.yScroll,
                template: 'olivia',
                nodeBinding: {
                    field_0: "name",
                    field_1: "position",
                    img_0: "photo"
                },
                enableDragDrop: true,
                nodeDragDrop: true,
                nodeMouseClick: OrgChart.action.edit,
                nodeMouseDbClick: OrgChart.action.edit,
                defaultProfileImg: false,
                nodes: @json($chartNodes),
                nodeMenu: {
                    edit: {text:"Edit"},
                    add: {text:"Add"},
                    remove: { 
                        text: "Remove",
                        onClick: function(nodeId) {
                            console.log('Remove clicked for node:', nodeId);
                            handleRemoveOfficer(nodeId);
                        }
                    }
                },
                editUI: new editForm(),
            });

            // Handle drag and drop to update parent ID
            window.chart.on('drop', function(sender, draggedNodeId, droppedOnNodeId) {
                console.log('Node dragged:', draggedNodeId, 'Dropped on:', droppedOnNodeId);
                
                // Get the dragged node
                const draggedNode = chart.get(draggedNodeId);
                if (!draggedNode) {
                    console.error('Dragged node not found');
                    return;
                }

                // Update the node's parent ID
                const updateData = {
                    id: draggedNodeId,
                    parent_id: droppedOnNodeId
                };

                console.log('Updating node with data:', updateData);

                // Call Livewire to update the parent ID
                @this.call('updateOfficerParent', updateData).then((result) => {
                    if (result) {
                        console.log('Parent ID updated successfully');
                        // Reload the chart to reflect changes
                        @this.call('getChartData').then(newChartData => {
                            chart.load(newChartData);
                        });
                    } else {
                        console.error('Failed to update parent ID');
                    }
                });
            });

            window.chart.on('add', function(sender, nodeId, parentNodeId) {
                console.log('Add event triggered:', nodeId.pid);
                
                // This is the key fix - parentNodeId contains the actual parent ID
                
                // Generate temp email
                const tempEmail = `temp_${Date.now()}_${Math.random().toString(36).substr(2, 9)}@temp.com`;
                
                // Create new node with temporary ID
                const tempId = `_${Date.now()}`;
                
                // Set data for the new node
                const newNodeData = {
                    id: tempId,
                    name: 'New Officer',
                    position: 'New Position',
                    email: tempEmail,
                    phone: '000-000-0000',
                    address: 'No Address',
                    pid: nodeId.pid,
                    photo: ''
                };
                
                // Call Livewire method
                @this.call('addOfficer', newNodeData).then(success => {
                    if (success) {
                        console.log('Officer added successfully');
                    } else {
                        console.error('Failed to add officer');
                    }
                });
            });
            // Removing officer
            // Replace your current remove handler with this:
            // Replace your current remove handler with this:
            function handleRemoveOfficer(nodeId) {
                if (!nodeId) {
                    console.error('No nodeId provided for removal');
                    return;
                }

                const node = chart.get(nodeId);
                if (!node) {
                    console.error('Node not found in chart:', nodeId);
                    return;
                }

                if (confirm(`Are you sure you want to remove ${node.name}?`)) {
                    // Send to Livewire - pass as an object with id property
                    @this.call('removeOfficer', nodeId);
                    
                    // Optimistically remove from UI
                    chart.removeNode(nodeId);
                }
            }

            Livewire.on('officer-removed', (data) => {
            if (data) {
            console.log('Successfully removed officer:', data.id);
            } else {
            console.error('Failed to remove officer');
            // Reload the chart if removal failed
            window.chart.load(@json($this->getChartData()));
            }
            });


            Livewire.on('officerAdded', (data) => {
                console.log('Received officer data:', data);
                
                if (!data) {
                    console.error('No data received from officerAdded event');
                    return;
                }

                // Reload the chart with the new data
                @this.call('getChartData').then(newChartData => {
                    console.log('New chart data:', newChartData);
                    chart.load(newChartData);
                });
            });



            // Handle photo upload for chart
            window.chart.handlePhotoUpload = function(nodeId, formElement) {
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.accept = 'image/*';
                fileInput.style.display = 'none';
                
                fileInput.onchange = (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const photoInput = formElement.querySelector('input[binding="photo"]');
                            if (photoInput) {
                                photoInput.value = e.target.result;
                                photoInput.dispatchEvent(new Event('input'));
                            }
                            const node = this.get(nodeId);
                            if (node) {
                                node.photo = e.target.result;
                                this.update(node);
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                };

                document.body.appendChild(fileInput);
                fileInput.click();
                setTimeout(() => {
                    document.body.removeChild(fileInput);
                }, 1000);
            };

            // Custom template styles
            OrgChart.templates.olivia.size = [250, 120];
            OrgChart.templates.olivia.node = `
                <rect x="0" y="0" width="250" height="120" rx="16" ry="16" fill="#ffffff" stroke="#e5e7eb" stroke-width="1" filter="url(#shadow)" />
                <clipPath id="avatarClip">
                    <circle cx="40" cy="60" r="30" />
                </clipPath>
                <image preserveAspectRatio="xMidYMid slice" clip-path="url(#avatarClip)" 
                    x="10" y="30" width="60" height="60">
                </image>
                <text text-anchor="start" style="font-size:16px; fill:#111827; font-weight:600;" x="80" y="50"></text>
                <text text-anchor="start" style="font-size:13px; fill:#6b7280;" x="80" y="70"></text>
            `;

            OrgChart.templates.olivia.defs = `
                <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                    <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#000000" flood-opacity="0.1" />
                </filter>`;


            OrgChart.templates.olivia.defs = `
                <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                    <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#000000" flood-opacity="0.1" />
                </filter>`;

    });
            </script>
</div>
