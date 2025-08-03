import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';

interface DashboardStats {
    totalJobs?: number;
    totalApplications?: number;
    totalUsers?: number;
    recentJobs?: Array<{
        id: number;
        title: string;
        store_name: string;
        applications_count: number;
        created_at: string;
    }>;
    recentApplications?: Array<{
        id: number;
        job: {
            id: number;
            title: string;
            store_name: string;
        };
        status: string;
        created_at: string;
    }>;
}

interface Props {
    auth: {
        user: {
            id: number;
            name: string;
            role: string;
            email: string;
        };
    };
    stats?: DashboardStats;
    [key: string]: unknown;
}

export default function Dashboard({ auth, stats }: Props) {
    const { user } = auth;

    const getStatusBadge = (status: string) => {
        const statusConfig = {
            pending: { class: 'bg-yellow-100 text-yellow-800', label: '⏳ Menunggu' },
            reviewed: { class: 'bg-blue-100 text-blue-800', label: '👀 Ditinjau' },
            shortlisted: { class: 'bg-purple-100 text-purple-800', label: '📋 Terpilih' },
            interviewed: { class: 'bg-indigo-100 text-indigo-800', label: '🎤 Wawancara' },
            accepted: { class: 'bg-green-100 text-green-800', label: '✅ Diterima' },
            rejected: { class: 'bg-red-100 text-red-800', label: '❌ Ditolak' },
        };
        
        const config = statusConfig[status as keyof typeof statusConfig] || statusConfig.pending;
        return <Badge className={config.class}>{config.label}</Badge>;
    };

    return (
        <AppShell>
            <Head title="Dashboard - Loker Madura" />
            
            <div className="container mx-auto px-4 py-8">
                {/* Welcome Section */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        Selamat datang, {user.name}! 👋
                    </h1>
                    <p className="text-gray-600">
                        {user.role === 'admin' && 'Kelola seluruh sistem loker Madura dari dashboard ini.'}
                        {user.role === 'employer' && 'Kelola lowongan kerja dan lamaran untuk toko Anda.'}
                        {user.role === 'job_seeker' && 'Pantau lamaran kerja dan temukan peluang baru.'}
                    </p>
                </div>

                {/* Quick Actions */}
                <div className="bg-white rounded-lg shadow-sm border p-6 mb-8">
                    <h2 className="text-xl font-bold text-gray-900 mb-4">
                        🚀 Aksi Cepat
                    </h2>
                    
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        {user.role === 'admin' && (
                            <>
                                <Link href="/jobs">
                                    <Button className="w-full bg-blue-600 hover:bg-blue-700">
                                        📋 Kelola Semua Lowongan
                                    </Button>
                                </Link>
                                <Link href="/job-applications">
                                    <Button className="w-full bg-purple-600 hover:bg-purple-700">
                                        📝 Kelola Semua Lamaran
                                    </Button>
                                </Link>
                                <Link href="/jobs/create">
                                    <Button className="w-full bg-green-600 hover:bg-green-700">
                                        ➕ Buat Lowongan Baru
                                    </Button>
                                </Link>
                                <Link href="/jobs">
                                    <Button variant="outline" className="w-full">
                                        📊 Lihat Statistik
                                    </Button>
                                </Link>
                            </>
                        )}
                        
                        {user.role === 'employer' && (
                            <>
                                <Link href="/jobs/create">
                                    <Button className="w-full bg-green-600 hover:bg-green-700">
                                        ➕ Posting Lowongan Baru
                                    </Button>
                                </Link>
                                <Link href="/my-jobs">
                                    <Button className="w-full bg-blue-600 hover:bg-blue-700">
                                        🏪 Lowongan Saya
                                    </Button>
                                </Link>
                                <Link href="/job-applications">
                                    <Button className="w-full bg-purple-600 hover:bg-purple-700">
                                        📝 Lamaran Masuk
                                    </Button>
                                </Link>
                                <Link href="/jobs">
                                    <Button variant="outline" className="w-full">
                                        🔍 Lihat Semua Lowongan
                                    </Button>
                                </Link>
                            </>
                        )}
                        
                        {user.role === 'job_seeker' && (
                            <>
                                <Link href="/jobs">
                                    <Button className="w-full bg-orange-600 hover:bg-orange-700">
                                        🔍 Cari Lowongan Kerja
                                    </Button>
                                </Link>
                                <Link href="/job-applications">
                                    <Button className="w-full bg-blue-600 hover:bg-blue-700">
                                        📋 Lamaran Saya
                                    </Button>
                                </Link>
                                <Link href="/profile">
                                    <Button className="w-full bg-purple-600 hover:bg-purple-700">
                                        👤 Update Profil
                                    </Button>
                                </Link>
                                <Link href="/jobs">
                                    <Button variant="outline" className="w-full">
                                        💡 Tips Melamar Kerja
                                    </Button>
                                </Link>
                            </>
                        )}
                    </div>
                </div>

                {/* Stats Cards for Admin */}
                {user.role === 'admin' && stats && (
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div className="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                            <div className="text-3xl font-bold">{stats.totalJobs || 0}</div>
                            <div className="text-blue-100">Total Lowongan</div>
                        </div>
                        <div className="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                            <div className="text-3xl font-bold">{stats.totalApplications || 0}</div>
                            <div className="text-green-100">Total Lamaran</div>
                        </div>
                        <div className="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                            <div className="text-3xl font-bold">{stats.totalUsers || 0}</div>
                            <div className="text-purple-100">Total Pengguna</div>
                        </div>
                    </div>
                )}

                <div className="grid lg:grid-cols-2 gap-8">
                    {/* Recent Jobs for Employers/Admin */}
                    {(user.role === 'employer' || user.role === 'admin') && stats?.recentJobs && (
                        <div className="bg-white rounded-lg shadow-sm border p-6">
                            <div className="flex justify-between items-center mb-4">
                                <h2 className="text-xl font-bold text-gray-900">
                                    🏪 Lowongan Terbaru
                                </h2>
                                <Link href={user.role === 'employer' ? '/my-jobs' : '/jobs'}>
                                    <Button variant="outline" size="sm">
                                        Lihat Semua
                                    </Button>
                                </Link>
                            </div>
                            
                            <div className="space-y-4">
                                {stats.recentJobs.slice(0, 5).map((job) => (
                                    <div key={job.id} className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <h3 className="font-medium text-gray-900">
                                                <Link 
                                                    href={`/jobs/${job.id}`}
                                                    className="hover:text-orange-600"
                                                >
                                                    {job.title}
                                                </Link>
                                            </h3>
                                            <p className="text-sm text-gray-600">{job.store_name}</p>
                                        </div>
                                        <div className="text-right">
                                            <div className="text-sm font-medium text-gray-900">
                                                {job.applications_count} lamaran
                                            </div>
                                            <div className="text-xs text-gray-500">
                                                {new Date(job.created_at).toLocaleDateString('id-ID')}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                                
                                {stats.recentJobs.length === 0 && (
                                    <div className="text-center py-8">
                                        <div className="text-4xl mb-2">📭</div>
                                        <p className="text-gray-600">Belum ada lowongan</p>
                                        {user.role === 'employer' && (
                                            <Link href="/jobs/create" className="mt-2 inline-block">
                                                <Button size="sm">
                                                    ➕ Buat Lowongan Pertama
                                                </Button>
                                            </Link>
                                        )}
                                    </div>
                                )}
                            </div>
                        </div>
                    )}

                    {/* Recent Applications for Job Seekers */}
                    {user.role === 'job_seeker' && stats?.recentApplications && (
                        <div className="bg-white rounded-lg shadow-sm border p-6">
                            <div className="flex justify-between items-center mb-4">
                                <h2 className="text-xl font-bold text-gray-900">
                                    📝 Lamaran Terbaru
                                </h2>
                                <Link href="/job-applications">
                                    <Button variant="outline" size="sm">
                                        Lihat Semua
                                    </Button>
                                </Link>
                            </div>
                            
                            <div className="space-y-4">
                                {stats.recentApplications.slice(0, 5).map((application) => (
                                    <div key={application.id} className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <h3 className="font-medium text-gray-900">
                                                <Link 
                                                    href={`/jobs/${application.job.id}`}
                                                    className="hover:text-orange-600"
                                                >
                                                    {application.job.title}
                                                </Link>
                                            </h3>
                                            <p className="text-sm text-gray-600">{application.job.store_name}</p>
                                        </div>
                                        <div className="text-right">
                                            {getStatusBadge(application.status)}
                                            <div className="text-xs text-gray-500 mt-1">
                                                {new Date(application.created_at).toLocaleDateString('id-ID')}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                                
                                {stats.recentApplications.length === 0 && (
                                    <div className="text-center py-8">
                                        <div className="text-4xl mb-2">📭</div>
                                        <p className="text-gray-600">Belum ada lamaran</p>
                                        <Link href="/jobs" className="mt-2 inline-block">
                                            <Button size="sm">
                                                🔍 Mulai Cari Kerja
                                            </Button>
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    )}

                    {/* Tips Section */}
                    <div className="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-lg border border-orange-100 p-6">
                        <h2 className="text-xl font-bold text-orange-900 mb-4">
                            💡 Tips & Saran
                        </h2>
                        
                        <div className="space-y-3">
                            {user.role === 'job_seeker' && (
                                <>
                                    <div className="flex items-start space-x-2">
                                        <span className="text-orange-600">•</span>
                                        <p className="text-orange-800 text-sm">
                                            Lengkapi profil Anda dengan informasi yang akurat dan menarik
                                        </p>
                                    </div>
                                    <div className="flex items-start space-x-2">
                                        <span className="text-orange-600">•</span>
                                        <p className="text-orange-800 text-sm">
                                            Tulis surat lamaran yang spesifik untuk setiap posisi
                                        </p>
                                    </div>
                                    <div className="flex items-start space-x-2">
                                        <span className="text-orange-600">•</span>
                                        <p className="text-orange-800 text-sm">
                                            Pantau status lamaran Anda secara berkala
                                        </p>
                                    </div>
                                </>
                            )}
                            
                            {user.role === 'employer' && (
                                <>
                                    <div className="flex items-start space-x-2">
                                        <span className="text-orange-600">•</span>
                                        <p className="text-orange-800 text-sm">
                                            Tulis deskripsi pekerjaan yang jelas dan detail
                                        </p>
                                    </div>
                                    <div className="flex items-start space-x-2">
                                        <span className="text-orange-600">•</span>
                                        <p className="text-orange-800 text-sm">
                                            Respon lamaran dengan cepat untuk mendapatkan kandidat terbaik
                                        </p>
                                    </div>
                                    <div className="flex items-start space-x-2">
                                        <span className="text-orange-600">•</span>
                                        <p className="text-orange-800 text-sm">
                                            Gunakan fitur notifikasi WhatsApp untuk update otomatis
                                        </p>
                                    </div>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}