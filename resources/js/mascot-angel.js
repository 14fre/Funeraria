/**
 * Ángel mascota: vuela por la pantalla siguiendo una trayectoria (GSAP).
 * Solo se ejecuta si existe .mascot-angel en la página.
 */
import gsap from 'gsap';

const mascot = document.querySelector('.mascot-angel');
if (mascot) {
  const waypoints = [
    { x: 8, y: 88 },
    { x: 15, y: 60 },
    { x: 28, y: 35 },
    { x: 50, y: 18 },
    { x: 72, y: 35 },
    { x: 85, y: 60 },
    { x: 92, y: 88 },
    { x: 75, y: 75 },
    { x: 50, y: 65 },
    { x: 25, y: 75 },
    { x: 8, y: 88 },
  ];
  const duration = 2.2;

  gsap.set(mascot, {
    left: waypoints[0].x + '%',
    top: waypoints[0].y + '%',
    xPercent: -50,
    yPercent: -50,
    rotation: -15,
  });

  const tl = gsap.timeline({ repeat: -1, repeatDelay: 0.4 });
  waypoints.slice(1).forEach((point, i) => {
    const prev = waypoints[i];
    const next = point;
    const dx = next.x - prev.x;
    const dy = next.y - prev.y;
    const angle = Math.atan2(dy, dx);
    const rotation = (angle * 180 / Math.PI) - 90;
    tl.to(mascot, {
      left: next.x + '%',
      top: next.y + '%',
      rotation,
      duration,
      ease: 'sine.inOut',
    });
  });
}
