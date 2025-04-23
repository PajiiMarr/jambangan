<div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-2xl font-bold">Officers </h1>
        <div id="tree" wire:ignore></div>
    </div>
    <script>
        let chart = new OrgChart("#tree", {
            showYScroll: true,
            mouseScrool: OrgChart.action.yScroll,
            template: 'olivia',
            nodeBinding: {
                field_0: "name",
                img_0: "photo",
            },
            defaultProfileImg: true, 
            nodes: [
                { id: 1, name: "Ava Field", photo: "https://randomuser.me/api/portraits/women/2.jpg" },
                { id: 2, pid: 1, name: "Ava Field", photo: "https://randomuser.me/api/portraits/women/2.jpg" },
                { id: 3, pid: 1, name: "Peter Stevens", photo: "https://randomuser.me/api/portraits/men/3.jpg" }
            ],
            nodeMenu:{
                edit: {text:"Edit"},
                add: {text:"Add"},
                remove: {text:"Remove"}
            },
            editForm: {
                generateElementsFromFields: false,
                photoBinding: "photo",
                elements: [
                    { type: 'textbox', label: 'Name', binding: 'name' },
                    { type: 'textbox', label: 'Position', binding: 'position' },
                    { type: 'textbox', label: 'Email', binding: 'email' },
                    { type: 'textbox', label: 'Phone', binding: 'phone' },
                    { type: 'textbox', label: 'Address', binding: 'address' },
                    { type: 'textbox', label: 'Photo Url', binding: 'photo', btn: 'Upload' },
                ],
                buttons: {
                    edit: {
                        icon: OrgChart.icon.edit(24, 24, '#fff'),
                        text: 'Edit',
                        hideIfEditMode: true,
                        hideIfDetailsMode: false
                    },
                    remove: {
                        icon: OrgChart.icon.remove(24, 24, '#fff'),
                        text: 'Remove',
                        hideIfDetailsMode: false
                    },
                    pdf: null,
                    share: null,
                }
            },
        });

        chart.editUI.on('field', function(sender, args) {
            if (args.name === "photo") {
                var input = args.input;

                input.addEventListener("change", function(event) {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                    args.value = e.target.result;
                    // Optionally save this to server here
                    };
                    reader.readAsDataURL(file);
                }
                });
            }
        });


        // Your existing template configurations...
        OrgChart.templates.olivia.editFormHeaderColor = '#dc2626';
        OrgChart.scroll.smooth = 12;
        OrgChart.scroll.speed = 120; 
        OrgChart.templates.olivia.size = [250, 120];

        OrgChart.templates.olivia.node =
            `<rect x="0" y="0" width="250" height="120" rx="16" ry="16" fill="#ffffff" stroke="#e5e7eb" stroke-width="1" filter="url(#shadow)" />
            <clipPath id="avatarClip">
                <circle cx="40" cy="60" r="30" />
            </clipPath>
            <image preserveAspectRatio="xMidYMid slice" clip-path="url(#avatarClip)" xlink:href="%{photo}" x="10" y="30" width="60" height="60"></image>
            <text text-anchor="start" style="font-size:16px; fill:#111827; font-weight:600;" x="80" y="65"></text>`;


        OrgChart.templates.olivia.defs =
            `<filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#000000" flood-opacity="0.1" />
            </filter>`;

            
    </script>
</div>