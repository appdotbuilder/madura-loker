import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';

interface Job {
    id: number;
    title: string;
    description: string;
    store_name: string;
    store_address: string;
    store_phone: string;
    salary_min: number | null;
    salary_max: number | null;
    salary_type: string;
    requirements: string | null;
    benefits: string | null;
    work_type: string;
    positions_available: number;
    application_deadline: string | null;
    status: string;
    published_at: string;
    category: {
        id: number;
        name: string;
        slug: string;
    };
    user: {
        id: number;
        name: string;
    };
}

interface Props {
    job: Job;
    hasApplied: boolean;
    auth?: {
        user?: {
            id: number;
            name: string;
            role: string;
        };
    };
    [key: string]: unknown;
}

export default function JobShow({ job, hasApplied, auth }: Props) {
    const formatSalary = (min: number | null, max: number | null, type: string) => {
        if (!min && !max) return 'Gaji Negotiable';
        
        const formatNumber = (num: number) => new Intl.NumberFormat('id-ID').format(num);
        const typeLabel = {
            hourly: '/jam',
            daily: '/hari',
            weekly: '/minggu',
            monthly: '/bulan'
        }[type] || '';

        if (min && max && min !== max) {
            return `Rp ${formatNumber(min)} - ${formatNumber(max)}${typeLabel}`;
        } else {
            return `Rp ${formatNumber(min || max || 0)}${typeLabel}`;
        }
    };

    const workTypeLabels = {
        'full-time': 'Full Time',
        'part-time': 'Part Time',
        'contract': 'Kontrak',
        'freelance': 'Freelance'
    };

    const canEdit = auth?.user && (auth.user.role === 'admin' || job.user.id === auth.user.id);
    const isDeadlinePassed = job.application_deadline && new Date(job.application_deadline) < new Date();

    return (
        <AppShell>
            <Head title={`${job.title} - ${job.store_name} | Loker Madura`} />
            
            <div className="container mx-auto px-4 py-8">
                {/* Back Button */}
                <div className="mb-6">
                    <Link href="/jobs">
                        <Button variant="outline" size="sm">
                            ← Kembali ke Daftar Lowongan
                        </Button>
                    </Link>
                </div>

                <div className="grid lg:grid-cols-3 gap-8">
                    {/* Main Content */}
                    <div className="lg:col-span-2">
                        <div className="bg-white rounded-lg shadow-sm border p-6">
                            {/* Job Header */}
                            <div className="border-b pb-6 mb-6">
                                <div className="flex items-center gap-2 mb-3">
                                    <Badge variant="secondary">
                                        {job.category.name}
                                    </Badge>
                                    <Badge 
                                        variant="outline" 
                                        className={job.work_type === 'full-time' ? 'border-green-300 text-green-700' : 'border-blue-300 text-blue-700'}
                                    >
                                        {workTypeLabels[job.work_type as keyof typeof workTypeLabels]}
                                    </Badge>
                                    {job.status === 'active' && (
                                        <Badge className="bg-green-100 text-green-800">
                                            🟢 Aktif
                                        </Badge>
                                    )}
                                </div>
                                
                                <h1 className="text-3xl font-bold text-gray-900 mb-4">
                                    {job.title}
                                </h1>
                                
                                <div className="flex items-center text-gray-600 mb-2">
                                    <span className="mr-2">🏪</span>
                                    <span className="text-lg font-medium">{job.store_name}</span>
                                </div>
                                
                                <div className="flex items-center text-gray-600 mb-4">
                                    <span className="mr-2">📍</span>
                                    <span>{job.store_address}</span>
                                </div>
                                
                                <div className="text-2xl font-bold text-orange-600">
                                    {formatSalary(job.salary_min, job.salary_max, job.salary_type)}
                                </div>
                            </div>

                            {/* Job Description */}
                            <div className="mb-8">
                                <h2 className="text-xl font-bold text-gray-900 mb-4">
                                    📋 Deskripsi Pekerjaan
                                </h2>
                                <div className="prose max-w-none">
                                    <p className="text-gray-700 leading-relaxed whitespace-pre-line">
                                        {job.description}
                                    </p>
                                </div>
                            </div>

                            {/* Requirements */}
                            {job.requirements && (
                                <div className="mb-8">
                                    <h2 className="text-xl font-bold text-gray-900 mb-4">
                                        ✅ Persyaratan
                                    </h2>
                                    <div className="prose max-w-none">
                                        <p className="text-gray-700 leading-relaxed whitespace-pre-line">
                                            {job.requirements}
                                        </p>
                                    </div>
                                </div>
                            )}

                            {/* Benefits */}
                            {job.benefits && (
                                <div className="mb-8">
                                    <h2 className="text-xl font-bold text-gray-900 mb-4">
                                        🎁 Fasilitas & Tunjangan
                                    </h2>
                                    <div className="prose max-w-none">
                                        <p className="text-gray-700 leading-relaxed whitespace-pre-line">
                                            {job.benefits}
                                        </p>
                                    </div>
                                </div>
                            )}

                            {/* Actions for Employers */}
                            {canEdit && (
                                <div className="border-t pt-6">
                                    <div className="flex gap-2">
                                        <Link href={`/jobs/${job.id}/edit`}>
                                            <Button variant="outline">
                                                ✏️ Edit Lowongan
                                            </Button>
                                        </Link>
                                        <Button 
                                            variant="destructive"
                                            onClick={() => {
                                                if (confirm('Apakah Anda yakin ingin menghapus lowongan ini?')) {
                                                    router.delete(`/jobs/${job.id}`);
                                                }
                                            }}
                                        >
                                            🗑️ Hapus Lowongan
                                        </Button>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="lg:col-span-1">
                        <div className="bg-white rounded-lg shadow-sm border p-6 mb-6">
                            <h3 className="text-lg font-bold text-gray-900 mb-4">
                                📊 Detail Lowongan
                            </h3>
                            
                            <div className="space-y-4">
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Posisi Tersedia:</span>
                                    <span className="font-medium">{job.positions_available}</span>
                                </div>
                                
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Tipe Pekerjaan:</span>
                                    <span className="font-medium">
                                        {workTypeLabels[job.work_type as keyof typeof workTypeLabels]}
                                    </span>
                                </div>
                                
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Kategori:</span>
                                    <span className="font-medium">{job.category.name}</span>
                                </div>
                                
                                {job.application_deadline && (
                                    <div className="flex justify-between">
                                        <span className="text-gray-600">Batas Lamaran:</span>
                                        <span className={`font-medium ${isDeadlinePassed ? 'text-red-600' : 'text-green-600'}`}>
                                            {new Date(job.application_deadline).toLocaleDateString('id-ID')}
                                        </span>
                                    </div>
                                )}
                                
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Diposting:</span>
                                    <span className="font-medium">
                                        {new Date(job.published_at).toLocaleDateString('id-ID')}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {/* Contact Information */}
                        <div className="bg-white rounded-lg shadow-sm border p-6 mb-6">
                            <h3 className="text-lg font-bold text-gray-900 mb-4">
                                📞 Kontak Toko
                            </h3>
                            
                            <div className="space-y-3">
                                <div>
                                    <div className="text-gray-600 text-sm">Nama Toko:</div>
                                    <div className="font-medium">{job.store_name}</div>
                                </div>
                                
                                <div>
                                    <div className="text-gray-600 text-sm">Alamat:</div>
                                    <div className="font-medium">{job.store_address}</div>
                                </div>
                                
                                <div>
                                    <div className="text-gray-600 text-sm">Telepon:</div>
                                    <div className="font-medium">
                                        <a 
                                            href={`tel:${job.store_phone}`}
                                            className="text-orange-600 hover:text-orange-700"
                                        >
                                            {job.store_phone}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Apply Button */}
                        <div className="bg-white rounded-lg shadow-sm border p-6">
                            {!auth?.user ? (
                                <div className="text-center">
                                    <p className="text-gray-600 mb-4">
                                        Silakan masuk untuk melamar pekerjaan ini
                                    </p>
                                    <Link href="/login">
                                        <Button className="w-full bg-orange-600 hover:bg-orange-700">
                                            🔑 Masuk untuk Melamar
                                        </Button>
                                    </Link>
                                </div>
                            ) : auth.user.role !== 'job_seeker' ? (
                                <div className="text-center">
                                    <p className="text-gray-600">
                                        Hanya pencari kerja yang dapat melamar lowongan ini
                                    </p>
                                </div>
                            ) : hasApplied ? (
                                <div className="text-center">
                                    <div className="text-green-600 font-medium mb-2">
                                        ✅ Anda sudah melamar untuk posisi ini
                                    </div>
                                    <Link href="/job-applications">
                                        <Button variant="outline" className="w-full">
                                            📋 Lihat Status Lamaran
                                        </Button>
                                    </Link>
                                </div>
                            ) : isDeadlinePassed ? (
                                <div className="text-center">
                                    <div className="text-red-600 font-medium mb-2">
                                        ⏰ Batas waktu lamaran telah berakhir
                                    </div>
                                </div>
                            ) : job.status !== 'active' ? (
                                <div className="text-center">
                                    <div className="text-gray-600 font-medium">
                                        📋 Lowongan tidak aktif
                                    </div>
                                </div>
                            ) : (
                                <div className="text-center">
                                    <Link href={`/apply?job_id=${job.id}`}>
                                        <Button className="w-full bg-orange-600 hover:bg-orange-700 text-lg py-3">
                                            📝 Lamar Sekarang
                                        </Button>
                                    </Link>
                                    <p className="text-sm text-gray-600 mt-2">
                                        Klik untuk melamar pekerjaan ini
                                    </p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}