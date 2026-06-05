<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for a Catalog – Catalog.Inc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #1e2a3a 0%, #0A8F3C 100%);
            min-height: 100vh;
        }
        .progress-bar {
            height: 4px;
            background: rgba(255,255,255,0.2);
            border-radius: 2px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: #34D399;
            border-radius: 2px;
            transition: width 0.4s ease;
        }
        .form-step {
            display: none;
            animation: slideIn 0.4s ease;
        }
        .form-step.active { display: block; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .floating-label {
            position: relative;
        }
        .floating-label input,
        .floating-label textarea {
            width: 100%;
            padding: 18px 14px 8px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 0.95rem;
            background: #f9fafb;
            transition: border-color 0.2s, background 0.2s;
        }
        .floating-label input:focus,
        .floating-label textarea:focus {
            border-color: #0A8F3C;
            background: white;
            outline: none;
        }
        .floating-label label {
            position: absolute;
            top: 14px;
            left: 14px;
            font-size: 0.95rem;
            color: #9ca3af;
            pointer-events: none;
            transition: all 0.2s ease;
        }
        .floating-label input:focus ~ label,
        .floating-label input:not(:placeholder-shown) ~ label,
        .floating-label textarea:focus ~ label,
        .floating-label textarea:not(:placeholder-shown) ~ label {
            top: 4px;
            font-size: 0.7rem;
            color: #0A8F3C;
            font-weight: 500;
        }
        .btn-primary {
            background: #0A8F3C;
            color: white;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover { background: #047A2D; transform: translateY(-1px); }
        .btn-secondary {
            background: transparent;
            border: 1px solid #d1d5db;
            color: #374151;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-secondary:hover { background: #f3f4f6; }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(10,143,60,0.4); }
            70% { box-shadow: 0 0 0 12px rgba(10,143,60,0); }
            100% { box-shadow: 0 0 0 0 rgba(10,143,60,0); }
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }
        .step-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transition: background 0.3s;
        }
        .step-dot.done { background: #34D399; }
        .step-dot.active { background: white; box-shadow: 0 0 0 4px rgba(255,255,255,0.2); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-lg">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-white">
                <span>Catalog.</span><span class="text-green-400">Inc</span>
            </h1>
            <p class="text-sm text-gray-300">Get your online store</p>
        </div>

        <!-- Progress bar -->
        <div class="progress-bar mb-2">
            <div class="progress-fill" id="progress-fill" style="width: 33%;"></div>
        </div>
        <div class="step-indicator">
            <span class="step-dot active" id="dot1"></span>
            <span class="step-dot" id="dot2"></span>
            <span class="step-dot" id="dot3"></span>
        </div>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" action="{{ route('submission.store') }}" id="application-form">
            @csrf

            <!-- Step 1: Business Details -->
            <div class="form-step active" id="step1">
                <div class="bg-white p-6 rounded-xl shadow-sm space-y-4">
                    <h2 class="font-semibold text-lg text-gray-800">Business Details</h2>
                    <div class="floating-label">
                        <input type="text" name="business_name" id="biz_name" placeholder=" " required>
                        <label for="biz_name">Business Name *</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="whatsapp_number" id="wa_num" placeholder=" " required>
                        <label for="wa_num">WhatsApp Number *</label>
                    </div>
                    <div class="floating-label">
                        <input type="email" name="email" id="email" placeholder=" ">
                        <label for="email">Email (optional)</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="city" id="city" placeholder=" ">
                        <label for="city">City (optional)</label>
                    </div>
                    <div class="floating-label">
                        <textarea name="address" id="address" rows="2" placeholder=" "></textarea>
                        <label for="address">Address (optional)</label>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn-primary" onclick="nextStep(2)">Next: Products</button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Products -->
            <div class="form-step" id="step2">
                <div class="bg-white p-6 rounded-xl shadow-sm space-y-4">
                    <h2 class="font-semibold text-lg text-gray-800">Your Products</h2>
                    <p class="text-sm text-gray-500">Add up to 5 products. Upload a photo, name, and price for each.</p>
                    <div id="product-list" class="space-y-4">
                        <div class="border rounded-xl p-4 space-y-3">
                            <div class="floating-label">
                                <input type="file" name="products[0][photo]" accept="image/*" id="photo0" placeholder=" ">
                                <label for="photo0">Product Photo</label>
                            </div>
                            <div class="floating-label">
                                <input type="text" name="products[0][name]" id="pname0" placeholder=" ">
                                <label for="pname0">Product Name</label>
                            </div>
                            <div class="floating-label">
                                <input type="text" name="products[0][price]" id="pprice0" placeholder=" ">
                                <label for="pprice0">Price</label>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-product" class="text-sm text-green-600 hover:underline">+ Add another product</button>
                    <div class="flex justify-between">
                        <button type="button" class="btn-secondary" onclick="prevStep(1)">Back</button>
                        <button type="button" class="btn-primary" onclick="nextStep(3)">Next: Review</button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Review & Submit -->
            <div class="form-step" id="step3">
                <div class="bg-white p-6 rounded-xl shadow-sm space-y-4 text-center">
                    <div class="text-5xl mb-3">&#10003;</div>
                    <h2 class="font-semibold text-lg text-gray-800">Ready to submit?</h2>
                    <p class="text-sm text-gray-500">We'll create your catalog within 2 business hours. You'll be able to send us a WhatsApp message to confirm.</p>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="btn-secondary" onclick="prevStep(2)">Back</button>
                        <button type="submit" class="btn-primary pulse">Submit & Send via WhatsApp</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function showStep(step) {
            document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');
            // Update progress bar
            const percent = Math.round((step / totalSteps) * 100);
            document.getElementById('progress-fill').style.width = percent + '%';
            // Update dots
            for (let i = 1; i <= totalSteps; i++) {
                const dot = document.getElementById('dot' + i);
                dot.classList.remove('active', 'done');
                if (i < step) dot.classList.add('done');
                if (i === step) dot.classList.add('active');
            }
            currentStep = step;
        }

        function nextStep(step) { showStep(step); }
        function prevStep(step) { showStep(step); }

        // Add product row
        let productIndex = 1;
        document.getElementById('add-product').addEventListener('click', function() {
            if (productIndex >= 5) return;
            const container = document.getElementById('product-list');
            const template = `
                <div class="border rounded-xl p-4 space-y-3">
                    <div class="floating-label">
                        <input type="file" name="products[${productIndex}][photo]" accept="image/*" id="photo${productIndex}" placeholder=" ">
                        <label for="photo${productIndex}">Product Photo</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="products[${productIndex}][name]" id="pname${productIndex}" placeholder=" ">
                        <label for="pname${productIndex}">Product Name</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="products[${productIndex}][price]" id="pprice${productIndex}" placeholder=" ">
                        <label for="pprice${productIndex}">Price</label>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', template);
            productIndex++;
        });
    </script>
</body>
</html>
